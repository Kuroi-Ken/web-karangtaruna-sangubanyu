<?php
// app/Http/Controllers/Admin/StructureController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StructurePosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StructureController extends Controller
{
    public function index()
    {
        $structures = StructurePosition::orderBy('order')
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('admin.structure.index', compact('structures'));
    }

    public function create()
    {
        return view('admin.structure.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = [
            'position' => $request->position,
            'name' => $request->name,
            'phone' => $request->phone,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $path = $photo->storeAs('structure', $filename, 'public');
            $data['photo'] = $path;
        }

        StructurePosition::create($data);

        return redirect()->route('admin.structure.index')
            ->with('success', 'Structure position added successfully!');
    }

    public function edit(StructurePosition $structure)
    {
        return view('admin.structure.edit', compact('structure'));
    }

    public function update(Request $request, StructurePosition $structure)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = [
            'position' => $request->position,
            'name' => $request->name,
            'phone' => $request->phone,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($structure->photo) {
                Storage::disk('public')->delete($structure->photo);
            }

            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $path = $photo->storeAs('structure', $filename, 'public');
            $data['photo'] = $path;
        }

        $structure->update($data);

        return redirect()->route('admin.structure.index')
            ->with('success', 'Structure position updated successfully!');
    }

    public function destroy(StructurePosition $structure)
    {
        if ($structure->photo) {
            Storage::disk('public')->delete($structure->photo);
        }
        
        $structure->delete();

        return redirect()->route('admin.structure.index')
            ->with('success', 'Structure position deleted successfully!');
    }
}