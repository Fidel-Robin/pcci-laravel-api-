<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});


use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicantApproved;

Route::get('/test-email', function() {
    $dummy = (object) ['first_name' => 'Test', 'email' => 'fidelishmaelrobin12@gmail.com'];
    Mail::to($dummy->email)->send(new \App\Mail\ApplicantApproved($dummy));
    return 'Email sent!';
});



require __DIR__.'/auth.php';
