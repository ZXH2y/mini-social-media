<?php

use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;


//  ini mi dibawa dibilang API dongo!!!!
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/v1')->group(function(){

    // menghandle posts
    Route::prefix('posts')->group(function(){
        Route::get('/', [PostsController::class, 'index']);// mengambil semua data.
        Route::post('/', [PostsController::class, 'store']); // menyimpan data.
        Route::get('{id}', [PostsController::class, 'show']); // mengambil detail data by id
        Route::put('{id}', [PostsController::class, 'update']); // mengupdate data
        Route::delete('{id}', [PostsController::class, 'destroy']);  // menghapus data.

    });


    // mengandle comments
    Route::prefix('comments')->group(function(){
        Route::post('/', [CommentsController::class, 'store']); // simpan komentar baru
        Route::delete('{id}', [CommentsController::class, 'destroy']); // Menghapus komentar
    });

    // handle API like
    Route::prefix('likes')->group(function(){
        Route::post('/', [LikesController::class, 'store']); // Like komentar baru
        Route::delete('{id}', [LikesController::class, 'destroy']); // Menghapus like
    });
});





