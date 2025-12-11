<x-layout>
    <x-slot:title>Add Contact</x-slot:title>

    <div class="max-w-2xl mx-auto py-6">
        <h2 class="text-2xl font-bold text-white mb-6">Add New Contact Information</h2>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.contacts.store') }}" method="POST" class="bg-gray-800 rounded-lg p-6">
            @csrf

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Contact Type *</label>
                <select name="type" required
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Type</option>
                    <option value="whatsapp" {{ old('type') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                    <option value="instagram" {{ old('type') === 'instagram' ? 'selected' : '' }}>Instagram</option>
                </select>
                <p class="text-gray-400 text-sm mt-1">Choose the platform type</p>
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Label *</label>
                <input type="text" name="label" value="{{ old('label') }}" required
                    placeholder="e.g., Official WhatsApp, Instagram Resmi"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Display name for this contact</p>
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Value/Username *</label>
                <input type="text" name="value" value="{{ old('value') }}" required
                    placeholder="e.g., +62812345678 or @kartur_sangubanyu"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Phone number (with country code) or Instagram username</p>
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Link URL *</label>
                <input type="url" name="link" value="{{ old('link') }}" required
                    placeholder="e.g., https://wa.me/62812345678 or https://instagram.com/kartur_sangubanyu"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <div class="mt-2 p-3 bg-blue-500/10 border border-blue-500 rounded">
                    <p class="text-blue-400 text-sm font-semibold mb-2">Link Format Examples:</p>
                    <ul class="text-gray-300 text-sm space-y-1">
                        <li>• WhatsApp: <code class="bg-gray-700 px-2 py-0.5 rounded">https://wa.me/62812345678</code></li>
                        <li>• Instagram: <code class="bg-gray-700 px-2 py-0.5 rounded">https://instagram.com/username</code></li>
                    </ul>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Display Order</label>
                <input type="number" name="order" value="{{ old('order', 0) }}"
                    placeholder="0"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Lower number = displayed first (0 = top)</p>
            </div>

            <div class="mb-6">
                <label class="flex items-center text-white">
                    <input type="checkbox" name="is_active" value="1" checked
                        class="mr-2 rounded bg-gray-700 border-gray-600">
                    Active (Show on public page)
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                    Add Contact
                </button>
                <a href="{{ route('admin.contacts.index') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-md">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-layout>