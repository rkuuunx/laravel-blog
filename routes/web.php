<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes();

Route::group(["middleware" => "auth"],function(){

    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/show/{id}/post', [PostController::class, 'show'])->name('posts.show');
    Route::get('/edit/{id}/post', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/update/{id}/post', [PostController::class, 'update'])->name('posts.update');


    #comments
    Route::post('/comment/{post_id}/store',[CommentController::class,'store'])->name('comments.store');
    Route::delete('/comment/{id}/delete',[CommentController::class,'delete'])->name('comments.delete');

    #profile
    Route::get('/profile/{id}/show',[ProfileController::class,'show'])->name('profile.show');
});

