<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('mainpage');
});

// Rutas públicas
Route::get('/register', [RegisterController::class,'index'])->name('register');
Route::post('/register', [RegisterController::class,'store']);

Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class,'store']);

Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
Route::get('/{user:username}/posts/{post}', [PostController::class,'show'])->name('posts.show');

// Rutas protegidas (mirar en la docu de laravel que método se usa en cada caso)
Route::middleware('auth')->group(function() {
  
    Route::post('/logout', [LogoutController::class,'store'])->name('logout');
    Route::get('/posts/create', [PostController::class,'create'])->name('posts.create');
    Route::post('/images', [ImageController::class,'store'])->name('images.store');
    Route::post('/posts', [PostController::class,'store'])->name('posts.store');
    Route::post('/{user:username}/posts/{post}', [CommentsController::class,'store'])->name('comments.store');
    Route::delete('/posts/{post}', [PostController::class,'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');

});

Route::get('/authenticate', [RegisterController::class,'auth']);





