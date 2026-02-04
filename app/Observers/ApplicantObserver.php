<?php

namespace App\Observers;

use App\Models\Applicant;
use App\Mail\ApplicantApproved;
use Illuminate\Support\Facades\Mail;

class ApplicantObserver
{
    /**
     * Handle the Applicant "updated" event.
     */
    public function updated(Applicant $applicant)
    {
        // Check if 'status' changed to 'approved'
        if ($applicant->isDirty('status') && $applicant->status === 'approved') {
            // Send email to applicant
            Mail::to($applicant->email)->send(new ApplicantApproved($applicant));
        }
    }
}
