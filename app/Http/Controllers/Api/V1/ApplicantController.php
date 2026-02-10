<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApplicantRequest;
use App\Models\Applicant;
use App\Http\Resources\ApplicantResource;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();

        // Super_admin & admin → get all applicants
        if ($user->hasAnyRole(['super_admin', 'admin'])) {
            $applicants = Applicant::all();
        }

        // Treasurer → only approved applicants
        elseif ($user->hasRole('treasurer')) {
            $applicants = Applicant::where('status', 'approved')->get();
        }

        else {
            // default: empty collection
            $applicants = collect();
        }

        return ApplicantResource::collection($applicants);
    }

    // public function index()
    // {
    //     return ApplicantResource::collection(
    //         Applicant::query()
    //             ->when(
    //                 auth()->user()->hasRole('treasurer'),
    //                 fn ($q) => $q->where('status', 'approved')
    //             )
    //             ->get()
    //     );
    // }

    // Show all applicants (for super_admin only)
    // public function index()
    // {
    //     return ApplicantResource::collection(Applicant::all());
    // }


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

        $applicant = Applicant::create($data);

        return new ApplicantResource($applicant);
    }


    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant)
    {
        $user = auth()->user();

        // Treasurer can ONLY view approved applicants
        if ($user->hasRole('treasurer') && $applicant->status !== 'approved') {
            return response()->json([
                'message' => 'Access denied. Treasurer can only view approved applicants.'
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
}
