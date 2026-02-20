<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOwnApplicantRequest;
use App\Http\Resources\ApplicantResource;

class MemberApplicationController extends Controller
{
    public function show()
    {
        $application = auth()->user()->member->applicant;

        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        return new ApplicantResource($application);
    }

    public function update(UpdateOwnApplicantRequest $request)
    {
        $application = auth()->user()->member->applicant;

        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        $data = $request->validated();

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('applicants/photos', 'public');
        }

        if ($request->hasFile('mayors_permit')) {
            $data['mayors_permit_path'] = $request->file('mayors_permit')->store('applicants/permits', 'public');
        }

        $application->update($data);

        return new ApplicantResource($application);
    }
}
