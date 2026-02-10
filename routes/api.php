<?php

use App\Http\Controllers\Api\V1\PostController as PostController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Controllers\Api\V1\ApplicantController;
use App\Models\Applicant;
use App\Http\Controllers\Api\V1\MemberController;
use App\Http\Controllers\Api\V1\MembershipTypeController;


// Public route: applicant applies (anyone can submit)
Route::post('/v1/apply', [ApplicantController::class, 'store']);


// // Protected routes: only super_admin and treasurer can access applicants
// Route::middleware(['auth:sanctum', 'throttle:api', 'role:super_admin|treasurer'])->group(function(){
//     Route::prefix('v1')->group(function(){
//         // All CRUD operations require super_admin role
//         Route::apiResource('applicants', ApplicantController::class);
//     });
// });

// READ
Route::middleware(['auth:sanctum', 'role:super_admin|treasurer'])
    ->get('/v1/applicants', [ApplicantController::class, 'index']);

Route::middleware(['auth:sanctum', 'role:super_admin|treasurer'])
    ->get('/v1/applicants/{applicant}', [ApplicantController::class, 'show']);


// WRITE (super_admin only)
Route::middleware(['auth:sanctum', 'role:super_admin'])->group(function () {
    Route::post('/v1/applicants', [ApplicantController::class, 'store']);
    Route::put('/v1/applicants/{applicant}', [ApplicantController::class, 'update']);
    Route::delete('/v1/applicants/{applicant}', [ApplicantController::class, 'destroy']);   
});


// WRITE MEMBER (Super Admin & Treasurer)
Route::middleware(['auth:sanctum', 'role:super_admin|treasurer'])->group(function () {
    Route::post('v1/members', [MemberController::class, 'store']);
});

// READ MEMBER (Super Admin & Treasurer)
Route::middleware(['auth:sanctum', 'role:super_admin|treasurer'])->group(function () {
    Route::get('v1/members', [MemberController::class, 'index']);
});
    

// WRITE (super_admin only)
Route::middleware(['auth:sanctum', 'role:super_admin'])->group(function () {
    Route::apiResource('v1/membership-types', MembershipTypeController::class); 
});










//=================
// Routes for posts (keeping as is, not implementing RBAC for posts per your request)
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function(){

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route::prefix('v1')->group(function(){
    //     Route::apiResource('posts', PostController::class);
    // });
});


require __DIR__.'/auth.php';