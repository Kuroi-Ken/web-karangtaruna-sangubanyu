<?php
// app/Http/Controllers/Admin/PostController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['author', 'category']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('body', 'like', '%' . $search . '%')
                  ->orWhere('author_name', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('activity', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('cate_id', $request->category);
        }

        $posts = $query->orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('activity', 'asc')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('activity', 'asc')->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cate_id' => 'required|exists:categories,id',
            'body' => 'required|string',
        ]);

        $imagePath = null;
        
        // Upload image jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('posts', $filename, 'public');
        }

        Post::create([
            'title' => $request->title,
            'author_id' => auth()->id(),
            'author_name' => $request->author_name,
            'image' => $imagePath,
            'cate_id' => $request->cate_id,
            'body' => $request->body,
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('activity', 'asc')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cate_id' => 'required|exists:categories,id',
            'body' => 'required|string',
        ]);

        $data = [
            'title' => $request->title,
            'author_name' => $request->author_name,
            'cate_id' => $request->cate_id,
            'body' => $request->body,
        ];

        // Upload image baru jika ada
        if ($request->hasFile('image')) {
            // Hapus image lama jika ada
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $data['image'] = $image->storeAs('posts', $filename, 'public');
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // Hapus image jika ada
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully!');
    }
}