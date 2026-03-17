<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApplicantRequest;
use App\Models\Applicant;
use App\Http\Resources\ApplicantResource;
use Illuminate\Support\Facades\Storage;


class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Applicant::query();

        // ROLE-BASED BASE RESTRICTIONS
        if ($user->hasRole('treasurer')) {
            // Treasurer can only see approved or paid
            $query->whereIn('status', ['approved', 'paid']);
        }

        elseif (! $user->hasAnyRole(['super_admin', 'admin'])) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 403);
        }

        // OPTIONAL FILTERING
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return ApplicantResource::collection($query->get());
    }

    public function store(StoreApplicantRequest $request)
    {
        $data = $request->validated();

        // Server-controlled fields
        $data['date_submitted'] = now();
        $data['status'] = 'pending';

        // 🚀 SWITCHING TO S3 (BACKBLAZE)
        
        // 1. Photo (Was 'public')
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('applicants/photos', 's3');
        }

        // 2. Mayor's Permit (Was 'local')
        if ($request->hasFile('mayors_permit')) {
            $data['mayors_permit_path'] = $request->file('mayors_permit')->store('applicants/documents', 's3');
        }

        // 3. DTI/SEC (Was 'local')
        if ($request->hasFile('dti_sec')) {
            $data['dti_sec_path'] = $request->file('dti_sec')->store('applicants/documents', 's3');
        }

        // 4. Proof of Payment (Was 'local')
        if ($request->hasFile('proof_of_payment')) {
            $data['proof_of_payment_path'] = $request->file('proof_of_payment')->store('applicants/documents', 's3');
        }

        $applicant = Applicant::create($data);

        return new ApplicantResource($applicant);
    }


    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant)
    {
        $user = auth()->user();

        if ($user->hasRole('treasurer') && 
            !in_array($applicant->status, ['approved', 'paid'])) {

            return response()->json([
                'message' => 'Access denied.'
            ], 403);
        }

        return new ApplicantResource($applicant);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applicant $applicant)
    {   
        $user = $request->user();

        /**
         * ADMIN / SUPER_ADMIN
         * - Can approve/reject
         * - Can set membership type
         */
        if ($user->hasAnyRole(['super_admin', 'admin'])) {

            $data = $request->validate([
                'status' => 'required|in:pending,approved,rejected,paid',
                'membership_type' => 'required|in:Charter,Life,Regular,Local Chamber,Trade/Industry Association,Affiliate',
            ]);

            // 🔒 Once approved, status cannot be changed
            if ($applicant->status === 'approved') {
                unset($data['status']);
            }

            // Set approval date once
            if (
                isset($data['status']) &&
                $data['status'] === 'approved' &&
                $applicant->date_approved === null
            ) {
                $data['date_approved'] = now();
            }

            $applicant->update($data);

            return new ApplicantResource($applicant);
        }


        /**
         * DEFAULT: DENY
         */
        return response()->json([
            'message' => 'Unauthorized action.'
        ], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Applicant $applicant)
    {
        $applicant->delete();
        return response()->noContent();
    }



    /**
     * NOTE: This method is now mostly for "forcing" a download.
     * With our new Resource, users can just click the temporaryUrl.
     */
    public function downloadDocument(Applicant $applicant, $type)
    {
        $user = auth()->user();
        if (! $user->hasAnyRole(['super_admin', 'admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $filePath = match ($type) {
            'photo' => $applicant->photo_path,
            'mayors_permit' => $applicant->mayors_permit_path,
            'dti_sec' => $applicant->dti_sec_path,
            'proof_of_payment' => $applicant->proof_of_payment_path,
            default => null,
        };

        // Check S3 disk instead of local
        if (!$filePath || !Storage::disk('s3')->exists($filePath)) {
            return response()->json(['message' => 'File not found on cloud storage'], 404);
        }

        return Storage::disk('s3')->download($filePath);
    }

}
