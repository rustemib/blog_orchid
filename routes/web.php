<?php

use App\Http\Controllers\Comment\CommentDeleteController;
use App\Http\Controllers\Comment\CommentEditController;
use App\Http\Controllers\Comment\CommentStoreController;
use App\Http\Controllers\Comment\CommentUpdateController;
use App\Http\Controllers\Post\PostIndexController;
use App\Http\Controllers\Post\PostShowController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PostIndexController::class, 'index'])->name('posts.index');
Route::get('/post/{id}', [PostShowController::class, 'show'])->name('post.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/post/{post}/comments', [CommentStoreController::class, 'store'])->name('post.comments.store');
    Route::get('/comments/{comment}/edit', [CommentEditController::class, 'edit'])->name('post.comment.edit');
    Route::put('/comments/{comment}/edit', [CommentUpdateController::class, 'update'])->name('post.comment.update');
    Route::delete('/comments/{comment}', [CommentDeleteController::class, 'destroy'])->name('post.comment.delete');
});


Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
