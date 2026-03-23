<?php

namespace App\Observers;

use App\Models\Applicant;
use App\Mail\ApplicantApprovedPaid;
use Illuminate\Support\Facades\Mail;

class ApplicantObserver
{
    /**
     * Handle the Applicant "updated" event.
     */
    public function updated(Applicant $applicant)
    {
        // Check if 'status' changed to 'paid'
        if ($applicant->isDirty('status') && $applicant->status === 'paid') {
            // Send email to applicant
            Mail::to($applicant->email)->send(new ApplicantApprovedPaid($applicant));
        }
    }
}
