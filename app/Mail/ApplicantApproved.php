<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicantApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;

    public function __construct($applicant)
    {
        $this->applicant = $applicant;
    }

    public function build()
    {
        return $this->subject('Your Application has been Approved')
                    ->view('emails.applicant_approved');
    }
}
