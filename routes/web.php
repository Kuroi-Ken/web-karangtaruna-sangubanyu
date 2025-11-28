<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title' => 'Home Page']);
});

Route::get('/posts', function () {
    // Gunakan eager loading untuk relasi author dan category
    return view('posts', [
        'title' => 'Blog', 
        'posts' => Post::with(['author', 'category'])->get()
    ]);
});

Route::get('/posts/{post}', function (Post $post) {
    return view('post', ['title' => 'Single Post', 'post' => $post]);
});

Route::get('/authors/{user:username}', function (User $user) {
    return view('posts', [
        'title' => count($user->posts ) . ' Article By ' . $user->name, 
        'posts' => $user->posts
    ]);
});

Route::get('/categories/{category}', function (Category $category) {
    return view('posts', [
        'title' => count($category->post) .  ' Articles in ' . $category->activity, 
        'posts' => $category->post
    ]);
});

Route::get('/contact', function () {
    return view('contact', ['title' => 'Kontak']);
});

Route::get('/about', function () {
    return view('about', ['title' => 'About', 'nama' => 'Faiz Nur Ramadhan']);
});