<?php
// app/Http/Controllers/Admin/ImageController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('admin.images.index', compact('images'));
    }

    public function create()
    {
        return view('admin.images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('images', $filename, 'public');

            Image::create([
                'title' => $request->title,
                'filename' => $filename,
                'path' => $path,
                'description' => $request->description,
                'is_active' => $request->has('is_active'),
                'order' => $request->order ?? 0,
            ]);

            return redirect()->route('admin.images.index')
                ->with('success', 'Image uploaded successfully!');
        }

        return back()->with('error', 'Failed to upload image.');
    }

    public function edit(Image $image)
    {
        return view('admin.images.edit', compact('image'));
    }

    public function update(Request $request, Image $image)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($image->path);

            $imageFile = $request->file('image');
            $filename = time() . '_' . $imageFile->getClientOriginalName();
            $path = $imageFile->storeAs('images', $filename, 'public');

            $data['filename'] = $filename;
            $data['path'] = $path;
        }

        $image->update($data);

        return redirect()->route('admin.images.index')
            ->with('success', 'Image updated successfully!');
    }

    public function destroy(Image $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()->route('admin.images.index')
            ->with('success', 'Image deleted successfully!');
    }
}