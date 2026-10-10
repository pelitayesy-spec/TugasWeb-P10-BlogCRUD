<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/posts');

// Route tambahan (bonus soft delete).
// PENTING: harus didaftarkan SEBELUM Route::resource, kalau tidak
// /posts/trash akan dianggap sebagai /posts/{post} dengan id "trash".
Route::get('posts/trash', [PostController::class, 'trash'])->name('posts.trash');
Route::patch('posts/{post}/restore', [PostController::class, 'restore'])
    ->withTrashed()->name('posts.restore');
Route::delete('posts/{post}/force-delete', [PostController::class, 'forceDestroy'])
    ->withTrashed()->name('posts.force-delete');

// 7 route CRUD sekaligus: posts.index, create, store, show, edit, update, destroy
Route::resource('posts', PostController::class);
