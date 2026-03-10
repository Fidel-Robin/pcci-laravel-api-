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
use App\Http\Controllers\Api\V1\ExpiringMembershipNotificationController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\MemberApplicationController;
use App\Http\Controllers\Api\V1\ActivityController;
use App\Http\Controllers\Api\V1\BoardOfTrusteeController;
use App\Http\Controllers\Api\V1\BoardPositionController;

// PUBLIC 
// Post ==>> Applicants
Route::post('/v1/apply', [ApplicantController::class, 'store']);

//Get ==>> Activities   
Route::get('v1/activities', [ActivityController::class, 'index']);

//Get ==>> Events
Route::get('/v1/events', [EventController::class, 'index']);
Route::get('/v1/events/{event}', [EventController::class, 'show']);

//Get ==>> Board of Trustees
Route::get('v1/trustees',[BoardOfTrusteeController::class,'index']);



use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema; // Important: Add this import

Route::get('/refresh-db', function () {
    try {
        // 1. Tell Postgres to ignore foreign key constraints temporarily
        Schema::disableForeignKeyConstraints();

        // 2. Run the migration and seeders
        // --force is required because Render runs in 'production' mode
        Artisan::call('migrate:fresh', [
            '--force' => true,
            '--seed' => true
        ]);

        // 3. Re-enable constraints now that all tables exist
        Schema::enableForeignKeyConstraints();

        return response()->json([
            'status' => 'success',
            'message' => 'Database wiped, migrated, and seeded successfully!'
        ]);
    } catch (\Exception $e) {
        // If it fails, try to re-enable constraints so the DB isn't left in a broken state
        Schema::enableForeignKeyConstraints();

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});



// SUPER ADMIN & ADMIN - MANAGE USERS, MEMBERSHIP TYPES, BOARD OF TRUSTEES, BOARD POSITIONS
Route::middleware(['auth:sanctum', 'role:super_admin|admin'])->group(function () {
    //Get, Post, Put, Delete ==>> Applicants
    // Route::get('/v1/applicants/', [ApplicantController::class, 'index']);
    // Route::get('/v1/applicants/{applicant}', [ApplicantController::class, 'show']);
    Route::post('/v1/applicants', [ApplicantController::class, 'store']);
    Route::put('/v1/applicants/{applicant}', [ApplicantController::class, 'update']);
    Route::delete('/v1/applicants/{applicant}', [ApplicantController::class, 'destroy']);
    
    //Get, Post, Put,  ==>> Membership Types
    Route::apiResource('v1/membership-types', MembershipTypeController::class)->except(['destroy']);

    //Get ==>> Users
    Route::get('/v1/users', [RegisteredUserController::class, 'index']); // all users
    Route::get('/v1/users/{user}', [RegisteredUserController::class, 'show']); // single user details
    Route::get('/v1/users/roles/{role}', [RegisteredUserController::class, 'getByRole']); // filter by role

    // Post, Put, Delete ==>> Activities
    Route::post('v1/activities', [ActivityController::class, 'store']);
    Route::put('v1/activities/{activity}', [ActivityController::class, 'update']);
    Route::delete('v1/activities/{activity}', [ActivityController::class, 'destroy']);

    // Post, Put, Delete ==>> Events, Categories
    Route::apiResource('/v1/categories', CategoryController::class)->except(['show']);
    Route::apiResource('/v1/events', EventController::class)->except(['index', 'show']);
    

    // Get, Post, Put ==>> Board Positions
    Route::get('v1/positions',[BoardPositionController::class,'index']);
    Route::post('v1/positions',[BoardPositionController::class,'store']);
    Route::put('v1/positions/{boardPosition}',[BoardPositionController::class,'update']);

    // Post, Put, ==>> Board of Trustees
    // get method is public
    Route::post('v1/trustees',[BoardOfTrusteeController::class,'store']);
    Route::put('v1/trustees/{boardOfTrustee}',[BoardOfTrusteeController::class,'update']);    
});


// SUPER ADMIN & TREASURER
Route::middleware(['auth:sanctum', 'role:super_admin|treasurer'])->group(function(){
    
    // READ/WRITE PAYMENTS (Super Admin & Treasurer)
    Route::apiResource('v1/payments', PaymentController::class);
});


Route::middleware(['auth:sanctum', 'role:super_admin|admin|treasurer'])->group(function () {

    Route::get('/v1/applicants', [ApplicantController::class, 'index']);
    Route::get('/v1/applicants/{applicant}', [ApplicantController::class, 'show']);

    Route::get('v1/members', [MemberController::class, 'index']);
    Route::post('v1/members', [MemberController::class, 'store']);
    Route::put('v1/members/{member}', [MemberController::class, 'update']);

});


// SUPER ADMIN
Route::middleware(['auth:sanctum', 'role:super_admin'])->group(function () {

    //Delete ==>> Users 
    Route::delete('v1/trustees/{boardOfTrustee}',[BoardOfTrusteeController::class,'destroy']);
    Route::delete('v1/positions/{boardPosition}',[BoardPositionController::class,'destroy']);
});

//SUPER ADMIN and MEMBER
Route::middleware(['auth:sanctum', 'role:member|admin|super_admin'])->group(function () {
    // Post ==>> Products
    Route::apiResource('v1/products', ProductController::class);
});

Route::middleware(['auth:sanctum', 'role:member'])
    ->group(function () {
        // Get, Put ==>> Member Application
        Route::get('v1/application', [MemberApplicationController::class, 'show']);
        Route::put('v1/application', [MemberApplicationController::class, 'update']);
    });

//READ CURRENT USER
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function(){
    Route::get('/v1/user', function (Request $request) {
        return new UserResource($request->user());
    });
});


//GET FILES - ADMINS
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/v1/applicants/{applicant}/download/{type}', 
        [ApplicantController::class, 'downloadDocument'])
        ->name('applicants.download');
});










Route::get('/v1/notifications', [ExpiringMembershipNotificationController::class, 'index']);
Route::patch('/v1/notifications/{id}/read', [ExpiringMembershipNotificationController::class, 'markAsRead']);

require __DIR__.'/auth.php';