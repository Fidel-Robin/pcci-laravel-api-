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
    // Show all applicants (for registered users)
    public function index()
    {
        return ApplicantResource::collection(Applicant::all());
    }

    /**
     * Store a newly created resource in storage.
     */
     // Submit personal details
    public function store(StoreApplicantRequest $request)
    {
        $applicant = Applicant::create($request->validated());
        return new ApplicantResource($applicant);
    }

    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant)
    {
        
        // abort_if(Auth::id() !== $applicant->user_id, 403, 'Access denied');

        return new ApplicantResource($applicant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applicant $applicant)
    {
        $data = $request -> validate([
            'applicant_status' => 'required|in:pending,approved,rejected',
        ]);
        $applicant->update($data);
        return new ApplicantResource($applicant);
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
