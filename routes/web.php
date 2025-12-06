<?php
// routes/web.php

use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ImageController;

Route::get('/', function () {
    $images = Image::where('is_active', true)
        ->orderBy('order')
        ->orderBy('created_at', 'desc')
        ->get();
    
    return view('home', [
        'title' => 'Home Page',
        'images' => $images
    ]);
});

Route::get('/posts', function () {
    return view('posts', [
        'title' => 'Blog', 
        'posts' => Post::with(['author', 'category'])->get()
    ]);
});

Route::get('/posts/{post}', function (Post $post) {
    return view('post', ['title' => $post->title, 'post' => $post]);
});

Route::get('/authors/{user:username}', function (User $user) {
    return view('posts', [
        'title' => count($user->posts) . ' Article By ' . $user->name, 
        'posts' => $user->posts
    ]);
});

Route::get('/categories/{category:slug}', function (Category $category) {
    return view('posts', [
        'title' => count($category->post) . ' Articles in: ' . $category->activity, 
        'posts' => $category->post
    ]);
});

Route::get('/contact', function () {
    return view('contact', ['title' => 'Kontak']);
});

Route::get('/about', function () {
    return view('about', ['title' => 'About', 'nama' => 'Faiz Nur Ramadhan']);
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('posts', AdminPostController::class);
    Route::resource('images', ImageController::class);
});