<?php

use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\MessagesController;
use App\Http\Middleware\JWTMiddleware;

//  ini mi dibawa dibilang API dongo!!!!

Route::prefix('/v1')->group(function(){

    // handle auth
    Route::post('reqister', [JWTAuthController::class, 'register']);
    Route::post('login', [JWTAuthController::class, 'login']);

    // menghandle posts
    Route::middleware(JWTMiddleware::class)->prefix('posts')->group(function(){
        Route::get('/', [PostsController::class, 'index']);// mengambil semua data.
        Route::post('/', [PostsController::class, 'store']); // menyimpan data.
        Route::get('{id}', [PostsController::class, 'show']); // mengambil detail data by id
        Route::put('{id}', [PostsController::class, 'update']); // mengupdate data
        Route::delete('{id}', [PostsController::class, 'destroy']);  // menghapus data.

    });


    // mengandle comments
    Route::middleware(JWTMiddleware::class)->prefix('comments')->group(function(){
        Route::post('/', [CommentsController::class, 'store']); // simpan komentar baru
        Route::delete('{id}', [CommentsController::class, 'destroy']); // Menghapus komentar
    });

    // handle API like
    Route::middleware(JWTMiddleware::class)->prefix('likes')->group(function(){
        Route::post('/', [LikesController::class, 'store']); // Like komentar baru
        Route::delete('{id}', [LikesController::class, 'destroy']); // Menghapus like
    });

    // Menghandle Message
    Route::middleware(JWTMiddleware::class)->prefix('messages')->group(function(){
        Route::post('/', [MessagesController::class, 'store']); // kirim pesan
        Route::get('{id}', [MessagesController::class, 'show']); // melihat pesan by id
        Route::delete('{id}', [MessagesController::class, 'destroy']); // menghapus pesan
        Route::get('getMessages/{user_id}', [MessagesController::class, 'getMessages']); // melihat pesan pesan masuk berdasakan user id
    });

    // Belajar JWT, jsin web token
    // command: 
    // composer require tymon/jwt-auth
    // php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
    // php artisan jwt:secret
});





