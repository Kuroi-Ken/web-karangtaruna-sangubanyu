<?php
// app/Http/Controllers/Admin/ContactController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('order')
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('admin.contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:whatsapp,instagram',
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'link' => 'required|url|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        Contact::create([
            'type' => $request->type,
            'label' => $request->label,
            'value' => $request->value,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact information added successfully!');
    }

    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'type' => 'required|in:whatsapp,instagram',
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'link' => 'required|url|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $contact->update([
            'type' => $request->type,
            'label' => $request->label,
            'value' => $request->value,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact information updated successfully!');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact information deleted successfully!');
    }
}