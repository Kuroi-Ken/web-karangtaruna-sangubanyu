<?php
// routes/web.php

use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use App\Models\Category;
use App\Models\StructurePosition;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\StructureController;
use App\Http\Controllers\Admin\PostController as AdminPostController;

Route::get('/', function () {
    $images = Image::where('is_active', true)
        ->orderBy('order')
        ->orderBy('created_at', 'desc')
        ->get();
    
    return view('home', [
        'title' => 'Website Karang Taruna Desa Sangubanyu',
        'images' => $images
    ]);
});

Route::get('/posts', function () {
    $query = Post::with(['author', 'category']);
    
    // Search functionality
    if (request('search')) {
        $search = request('search');
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('body', 'like', '%' . $search . '%')
              ->orWhere('author_name', 'like', '%' . $search . '%')
              ->orWhereHas('category', function($q) use ($search) {
                  $q->where('activity', 'like', '%' . $search . '%');
              });
        });
    }
    
    // Filter by category
    if (request('category')) {
        $query->where('cate_id', request('category'));
    }
    
    // Filter by author name
    if (request('author')) {
        $query->where('author_name', request('author'));
    }
    
    // Sorting
    $sortBy = request('sort', 'latest');
    
    switch ($sortBy) {
        case 'oldest':
            $query->orderBy('created_at', 'asc');
            break;
        case 'title':
            $query->orderBy('title', 'asc');
            break;
        case 'author':
            $query->orderBy('author_name', 'asc');
            break;
        case 'latest':
        default:
            $query->orderBy('created_at', 'desc');
            break;
    }
    
    $posts = $query->get();
    $categories = Category::orderBy('activity', 'asc')->get();
    
    // Get unique author names
    $authors = Post::whereNotNull('author_name')
        ->select('author_name')
        ->distinct()
        ->orderBy('author_name', 'asc')
        ->pluck('author_name');
    
    return view('posts', [
        'title' => 'Blog', 
        'posts' => $posts,
        'categories' => $categories,
        'authors' => $authors
    ]);
})->name('posts.index');

// Tambahkan named route untuk detail post
Route::get('/posts/{post}', function (Post $post) {
    return view('post', ['title' => $post->title, 'post' => $post]);
})->name('post.show');

Route::get('/authors/{user:username}', function (User $user) {
    return view('posts', [
        'title' => count($user->posts) . ' Article By ' . $user->name, 
        'posts' => $user->posts,
        'categories' => Category::orderBy('activity', 'asc')->get(),
        'authors' => Post::whereNotNull('author_name')
            ->select('author_name')
            ->distinct()
            ->orderBy('author_name', 'asc')
            ->pluck('author_name')
    ]);
});

Route::get('/categories/{category:slug}', function (Category $category) {
    return view('posts', [
        'title' => count($category->post) . ' Articles in: ' . $category->activity, 
        'posts' => $category->post,
        'categories' => Category::orderBy('activity', 'asc')->get(),
        'authors' => Post::whereNotNull('author_name')
            ->select('author_name')
            ->distinct()
            ->orderBy('author_name', 'asc')
            ->pluck('author_name')
    ]);
});

Route::get('/contact', function () {
    return view('contact', ['title' => 'Kontak']);
});

Route::get('/about', function () {
    return view('about', ['title' => 'Tentang Kami', 'nama' => 'Faiz Nur Ramadhan']);
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

Route::get('/struktur', function () {
    $structures = StructurePosition::where('is_active', true)
        ->orderBy('order')
        ->orderBy('created_at', 'asc')
        ->get();
    
    return view('struktur', [
        'title' => 'Struktur Organisasi',
        'structures' => $structures
    ]);
});

// Tambahkan di dalam admin group (setelah images route)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('posts', AdminPostController::class);
    Route::resource('images', ImageController::class);
    Route::resource('structure', StructureController::class); // ← TAMBAH INI
});