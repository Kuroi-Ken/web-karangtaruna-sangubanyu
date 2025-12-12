<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('is_published', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $documents = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = Document::whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('admin.documents.index', compact('documents', 'categories'));
    }

    public function create()
    {
        $existingCategories = Document::whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
            
        return view('admin.documents.create', compact('existingCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // Max 10MB
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('dokumen', $fileName, 'public');

            Document::create([
                'title' => $request->title,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'description' => $request->description,
                'category' => $request->category,
                'is_published' => $request->has('is_published'),
                'order' => $request->order ?? 0,
            ]);

            return redirect()->route('admin.documents.index')
                ->with('success', 'Dokumen berhasil ditambahkan!');
        }

        return back()->with('error', 'Gagal mengupload file.');
    }

    public function edit(Document $document)
    {
        $existingCategories = Document::whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
            
        return view('admin.documents.edit', compact('document', 'existingCategories'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'is_published' => $request->has('is_published'),
            'order' => $request->order ?? 0,
        ];

        // Upload new file if exists
        if ($request->hasFile('file')) {
            // Delete old file
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('dokumen', $fileName, 'public');

            $data['file_name'] = $file->getClientOriginalName();
            $data['file_path'] = $filePath;
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['file_size'] = $file->getSize();
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy(Document $document)
    {
        // Delete file
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil dihapus!');
    }
}