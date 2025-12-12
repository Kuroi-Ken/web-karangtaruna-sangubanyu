<?php
// app/Http/Controllers/Admin/FinancialReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FinancialReportController extends Controller
{
    public function index(Request $request)
    {
        $query = FinancialReport::query();

        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('report_type', $request->type);
        }

        // Filter by year
        if ($request->has('year') && $request->year != '') {
            $query->where('year', $request->year);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('is_published', $request->status);
        }

        $reports = $query->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->orderBy('quarter', 'desc')
            ->orderBy('order')
            ->get();

        $years = FinancialReport::selectRaw('DISTINCT year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.financial-reports.index', compact('reports', 'years'));
    }

    public function create()
    {
        return view('admin.financial-reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'report_type' => 'required|in:monthly,quarterly,yearly',
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'nullable|integer|min:1|max:12',
            'quarter' => 'nullable|integer|min:1|max:4',
            'income' => 'required|numeric|min:0',
            'expense' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:5120', // Max 5MB
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        $data = $request->only([
            'title', 'report_type', 'year', 'month', 'quarter',
            'income', 'expense', 'description', 'order'
        ]);

        // Calculate balance
        $data['balance'] = $request->income - $request->expense;
        $data['is_published'] = $request->has('is_published');

        // Upload file if exists
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('financial-reports', $filename, 'public');
            $data['file_path'] = $path;
        }

        FinancialReport::create($data);

        return redirect()->route('admin.financial-reports.index')
            ->with('success', 'Laporan keuangan berhasil ditambahkan!');
    }

    public function edit(FinancialReport $financialReport)
    {
        return view('admin.financial-reports.edit', compact('financialReport'));
    }

    public function update(Request $request, FinancialReport $financialReport)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'report_type' => 'required|in:monthly,quarterly,yearly',
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'nullable|integer|min:1|max:12',
            'quarter' => 'nullable|integer|min:1|max:4',
            'income' => 'required|numeric|min:0',
            'expense' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:5120',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        $data = $request->only([
            'title', 'report_type', 'year', 'month', 'quarter',
            'income', 'expense', 'description', 'order'
        ]);

        $data['balance'] = $request->income - $request->expense;
        $data['is_published'] = $request->has('is_published');

        // Upload new file if exists
        if ($request->hasFile('file')) {
            // Delete old file
            if ($financialReport->file_path) {
                Storage::disk('public')->delete($financialReport->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('financial-reports', $filename, 'public');
            $data['file_path'] = $path;
        }

        $financialReport->update($data);

        return redirect()->route('admin.financial-reports.index')
            ->with('success', 'Laporan keuangan berhasil diperbarui!');
    }

    public function destroy(FinancialReport $financialReport)
    {
        // Delete file if exists
        if ($financialReport->file_path) {
            Storage::disk('public')->delete($financialReport->file_path);
        }

        $financialReport->delete();

        return redirect()->route('admin.financial-reports.index')
            ->with('success', 'Laporan keuangan berhasil dihapus!');
    }
}