<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::orderBy('created_at', 'desc')->get();
        $activeAbout = About::where('is_active', true)->first();
        
        return view('admin.about.index', compact('about', 'activeAbout'));
    }

    public function create()
    {
        return view('admin.about.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'vision' => 'required|string',
            'mission' => 'required|array|min:1',
            'mission.*' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'vision' => $request->vision,
            'mission' => array_filter($request->mission), // Remove empty items
            'is_active' => $request->has('is_active'),
        ];

        // If set as active, deactivate others
        if ($request->has('is_active')) {
            About::where('is_active', true)->update(['is_active' => false]);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('about', $filename, 'public');
            $data['image'] = $path;
        }

        About::create($data);

        return redirect()->route('admin.about.index')
            ->with('success', 'About information created successfully!');
    }

    public function edit(About $about)
    {
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'vision' => 'required|string',
            'mission' => 'required|array|min:1',
            'mission.*' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'vision' => $request->vision,
            'mission' => array_filter($request->mission),
            'is_active' => $request->has('is_active'),
        ];

        // If set as active, deactivate others
        if ($request->has('is_active')) {
            About::where('id', '!=', $about->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('about', $filename, 'public');
            $data['image'] = $path;
        }

        $about->update($data);

        return redirect()->route('admin.about.index')
            ->with('success', 'About information updated successfully!');
    }

    public function destroy(About $about)
    {
        if ($about->is_active) {
            return redirect()->route('admin.about.index')
                ->with('error', 'Cannot delete active about page. Please set another page as active first.');
        }

        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }
        
        $about->delete();

        return redirect()->route('admin.about.index')
            ->with('success', 'About information deleted successfully!');
    }
}