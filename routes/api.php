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
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Api\V1\ProductController;



// Public route: applicant applies (anyone can submit)
Route::post('/v1/apply', [ApplicantController::class, 'store']);

// // Protected routes: only super_admin and treasurer can access applicants
// Route::middleware(['auth:sanctum', 'throttle:api', 'role:super_admin|treasurer'])->group(function(){
//     Route::prefix('v1')->group(function(){
//         // All CRUD operations require super_admin role
//         Route::apiResource('applicants', ApplicantController::class);
//     });
// });

//READ Applicants (Super Admin & Treasurer)
Route::middleware(['auth:sanctum', 'role:super_admin|treasurer'])
    ->get('/v1/applicants', [ApplicantController::class, 'index']);

Route::middleware(['auth:sanctum', 'role:super_admin|treasurer'])
    ->get('/v1/applicants/{applicant}', [ApplicantController::class, 'show']);


// WRITE Applicants (super_admin only)
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
    
// WRITE MEMBERSHIP TYPES (super_admin only)
Route::middleware(['auth:sanctum', 'role:super_admin'])->group(function () {
    Route::apiResource('v1/membership-types', MembershipTypeController::class); 
});

// READ/WRITE PAYMENTS (Super Admin & Treasurer)
Route::middleware(['auth:sanctum', 'role:super_admin|treasurer'])->group(function () {
    Route::apiResource('v1/payments', PaymentController::class);
});




//READ CURRENT USER
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function(){

    Route::get('/user', function (Request $request) {
        // return $request->user()->load('roles');
        // return $request->user();
        return new UserResource($request->user());
    });
});

Route::middleware(['auth:sanctum', 'role:super_admin'])->group(function () {
    Route::get('/v1/users', [RegisteredUserController::class, 'index']); // all users
    Route::get('/v1/users/{user}', [RegisteredUserController::class, 'show']); // single user details
    Route::get('/v1/users/roles/{role}', [RegisteredUserController::class, 'getByRole']); // filter by role
});


//GET FILES - ADMINS
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/v1/applicants/{applicant}/download/{type}', 
        [ApplicantController::class, 'downloadDocument'])
        ->name('applicants.download');
});


// POST PRODUCTS  -  MEMBER
Route::middleware(['auth:sanctum', 'role:super_admin|member'])->group(function () {
    Route::apiResource('v1/products', ProductController::class);
});

use App\Http\Controllers\Api\V1\MemberApplicationController;

Route::middleware(['auth:sanctum', 'role:member'])
    ->prefix('v1/member')
    ->group(function () {
        Route::get('/application', [MemberApplicationController::class, 'show']);
        Route::put('/application', [MemberApplicationController::class, 'update']);
    });





require __DIR__.'/auth.php';