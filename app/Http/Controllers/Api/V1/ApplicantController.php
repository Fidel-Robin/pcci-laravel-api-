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

    /**
     * Store a newly created resource in storage.
     */
     // Submit personal details
    public function store(StoreApplicantRequest $request)
    {
        $data = $request->validated();

        // Server-controlled fields
        $data['date_submitted'] = now();
        $data['status'] = 'pending';
        // $data['date_approved'] = now();

         if ($request->hasFile('photo')) {
            $data['photo_path'] =
                $request->file('photo')->store('documents', 'public'); // public storage
        }

        if ($request->hasFile('mayors_permit')) {
            $data['mayors_permit_path'] =
                $request->file('mayors_permit')->store('documents', 'local'); // private storage
        }

        if ($request->hasFile('dti_sec')) {
            $data['dti_sec_path'] =
                $request->file('dti_sec')->store('documents', 'local'); // private storage
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



    public function downloadDocument(Applicant $applicant, $type)
    {
        // Only admins or super_admin can download
        $user = auth()->user();
        if (! $user->hasAnyRole(['super_admin', 'admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $filePath = null;

        if ($type === 'photo') {
            $filePath = $applicant->photo_path;
        }
          elseif ($type === 'mayors_permit') {
            $filePath = $applicant->mayors_permit_path;
        } elseif ($type === 'dti_sec') {
            $filePath = $applicant->dti_sec_path;
        } else {
            return response()->json(['message' => 'Invalid document type'], 400);
        }

        if (!$filePath || !Storage::disk('local')->exists($filePath)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return Storage::disk('local')->download($filePath);
    }

}
