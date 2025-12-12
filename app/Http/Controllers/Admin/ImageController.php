<?php
// app/Http/Controllers/Admin/ImageController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $query = Image::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status);
        }

        $images = $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(10);
        
        // Get current hero image
        $heroImage = Image::where('is_hero', true)->first();
        
        return view('admin.images.index', compact('images', 'heroImage'));
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
            'is_hero' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            DB::beginTransaction();
            try {
                // Jika is_hero di-check, set semua image lain is_hero = false
                if ($request->has('is_hero')) {
                    Image::where('is_hero', true)->update(['is_hero' => false]);
                }

                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('images', $filename, 'public');

                Image::create([
                    'title' => $request->title,
                    'filename' => $filename,
                    'path' => $path,
                    'description' => $request->description,
                    'is_active' => $request->has('is_active'),
                    'is_hero' => $request->has('is_hero'),
                    'order' => $request->order ?? 0,
                ]);

                DB::commit();

                $message = $request->has('is_hero') 
                    ? 'Image uploaded and set as hero background successfully!' 
                    : 'Image uploaded successfully!';

                return redirect()->route('admin.images.index')
                    ->with('success', $message);
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Failed to upload image: ' . $e->getMessage());
            }
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
            'is_hero' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            // Jika is_hero di-check, set semua image lain is_hero = false
            if ($request->has('is_hero')) {
                Image::where('id', '!=', $image->id)
                    ->where('is_hero', true)
                    ->update(['is_hero' => false]);
            }

            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'is_active' => $request->has('is_active'),
                'is_hero' => $request->has('is_hero'),
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

            DB::commit();

            $message = $request->has('is_hero') 
                ? 'Image updated and set as hero background successfully!' 
                : 'Image updated successfully!';

            return redirect()->route('admin.images.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update image: ' . $e->getMessage());
        }
    }

    public function destroy(Image $image)
    {
        // Jangan izinkan hapus jika ini hero image
        if ($image->is_hero) {
            return redirect()->route('admin.images.index')
                ->with('error', 'Cannot delete hero background image. Please set another image as hero first.');
        }

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()->route('admin.images.index')
            ->with('success', 'Image deleted successfully!');
    }
}