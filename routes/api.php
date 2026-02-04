<?php

use App\Http\Controllers\Api\V1\PostController as PostController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Controllers\Api\V1\ApplicantController;
use App\Models\Applicant;


// Public route: applicant applies (anyone can submit)
Route::post('/v1/apply', [ApplicantController::class, 'store']);

// Public route: view all applicants (temporary - you may want to protect this later)
Route::get('/v1/applicants_pub', [ApplicantController::class, 'index']);


// Protected routes: only super_admin can access
Route::middleware(['auth:sanctum', 'throttle:api', 'super_admin'])->group(function(){
    Route::prefix('v1')->group(function(){
        // All CRUD operations require super_admin role
        Route::apiResource('applicants', ApplicantController::class);
    });
});


// Routes for posts (keeping as is, not implementing RBAC for posts per your request)
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function(){

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('v1')->group(function(){
        Route::apiResource('posts', PostController::class);
    });
});


// use Illuminate\Support\Facades\Mail;
// use App\Mail\ApplicantApproved;

// Route::get('/test-email', function() {
//     $dummy = (object) ['first_name' => 'Test', 'email' => 'fidelrevo@gmail.com'];
//     Mail::to($dummy->email)->send(new ApplicantApproved($dummy));
//     return 'Email sent!';
// });

require __DIR__.'/auth.php';