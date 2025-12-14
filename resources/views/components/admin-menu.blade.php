{{-- resources/views/components/admin-menu.blade.php --}}
<div class="bg-gray-800 rounded-lg p-4 mb-6">
    <nav class="flex flex-wrap gap-2">
        <a href="{{ route('admin.posts.index') }}" 
           class="{{ request()->routeIs('admin.posts.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-4 py-2 rounded-md text-sm font-medium transition">
            Blog
        </a>
        <a href="{{ route('admin.images.index') }}" 
           class="{{ request()->routeIs('admin.images.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-4 py-2 rounded-md text-sm font-medium transition">
            Gambar & Background
        </a>
        <a href="{{ route('admin.structure.index') }}" 
           class="{{ request()->routeIs('admin.structure.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-4 py-2 rounded-md text-sm font-medium transition">
            Struktur Organisasi
        </a>
        <a href="{{ route('admin.contacts.index') }}" 
           class="{{ request()->routeIs('admin.contacts.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-4 py-2 rounded-md text-sm font-medium transition">
            Kontak
        </a>
        <a href="{{ route('admin.about.index') }}" 
           class="{{ request()->routeIs('admin.about.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-4 py-2 rounded-md text-sm font-medium transition">
            Tentang Kami
        </a>
        <a href="{{ route('admin.financial-reports.index') }}" 
           class="{{ request()->routeIs('admin.financial-reports.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-4 py-2 rounded-md text-sm font-medium transition">
            Laporan Keuangan
        </a>
        <a href="{{ route('admin.documents.index') }}" 
           class="{{ request()->routeIs('admin.documents.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-4 py-2 rounded-md text-sm font-medium transition">
            Dokumen
        </a>
    </nav>
</div>