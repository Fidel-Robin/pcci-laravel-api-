<?php

use App\Http\Controllers\Api\V1\PostController as PostController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




// Route::get('/test', function() {
//     return response()->json([
//         'status' => 'API working',
//         'time' => now()
//     ]);
// });

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function(){

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('v1')->group(function(){
        Route::apiResource('posts', PostController::class);
    });
});



require __DIR__.'/auth.php';


