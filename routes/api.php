<?php

use App\Http\Controllers\Api\V1\PostController as PostController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/test', function() {
    return response()->json([
        'status' => 'API working',
        'time' => now()
    ]);
});

Route::get('/hello', function(){
    return ["message" => "Hello, World!"];
});

// Route::get('/posts', [PostController::class, 'index'])->name('post.index');
// Route::post('/posts', [PostController::class, 'store'])->name('post.store');
// Route::get('/posts/{id}', [PostController::class, 'show'])->name('post.show');


Route::prefix('v1')->group(function(){
    Route::apiResource('posts', PostController::class);
});




