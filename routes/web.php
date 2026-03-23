<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});


use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicantApprovedPaid;

Route::get('/test-email', function() {
    $dummy = (object) ['first_name' => 'Test', 'email' => 'fidelishmaelrobin12@gmail.com'];
    Mail::to($dummy->email)->send(new \App\Mail\ApplicantApprovedPaid($dummy));
    return 'Email sent!';
});


// use Illuminate\Support\Facades\Artisan;

// Route::get('/refresh-db', function () {
//     try {
//         // Clear caches to ensure new Env variables are read
//         Artisan::call('config:clear');
//         Artisan::call('cache:clear');

//         // Run migrations with force (required for production/render)
//         // This will drop tables and re-run seeders
//         Artisan::call('migrate:fresh', [
//             '--force' => true,
//             '--seed' => true
//         ]);

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Database wiped, migrated, and seeded successfully!'
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'status' => 'error',
//             'message' => $e->getMessage()
//         ], 500);
//     }
// });



require __DIR__.'/auth.php';
