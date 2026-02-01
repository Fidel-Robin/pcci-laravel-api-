<?php

use App\Http\Controllers\Api\V1\PostController as PostController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Controllers\Api\V1\ApplicantController;
use App\Models\Applicant;


// Route::get('/test', function() {
//     return response()->json([
//         'status' => 'API working',
//         'time' => now()
//     ]);
// });

// Route::get('/post', function () {
//     return response()->json(Post::all());
// });



// Public route: applicant applies
Route::post('/v1/apply', [ApplicantController::class, 'store']);


Route::get('/v1/applicants_pub', [ApplicantController::class, 'index']);


Route::middleware(['auth:sanctum', 'throttle:api'])->group(function(){

    Route::prefix('v1')->group(function(){
        Route::apiResource('applicants', ApplicantController::class);
    });

});


//routes for posts
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function(){

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('v1')->group(function(){
        Route::apiResource('posts', PostController::class);
    });
});



require __DIR__.'/auth.php';


