<div class="bg-gray-800 rounded-lg p-4 mb-6">
    <nav class="flex space-x-4">
        <a href="{{ route('admin.posts.index') }}" 
           class="{{ request()->routeIs('admin.posts.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-4 py-2 rounded-md text-sm font-medium transition">
            Posts
        </a>
        <a href="{{ route('admin.images.index') }}" 
           class="{{ request()->routeIs('admin.images.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-4 py-2 rounded-md text-sm font-medium transition">
            Images
        </a>
        <a href="{{ route('admin.structure.index') }}" 
           class="{{ request()->routeIs('admin.structure.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-4 py-2 rounded-md text-sm font-medium transition">
            Structure
        </a>
        <a href="{{ route('admin.contacts.index') }}" 
           class="{{ request()->routeIs('admin.contacts.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-4 py-2 rounded-md text-sm font-medium transition">
            Contact
        </a>
    </nav>
</div>