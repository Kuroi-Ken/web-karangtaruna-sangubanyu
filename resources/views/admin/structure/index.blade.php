<x-layout>
    <x-slot:title>Manage Structure</x-slot:title>

    <div class="py-6">
        <x-admin-menu />
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Organization Structure Management</h2>
            <a href="{{ route('admin.structure.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                Add New Position
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($structures as $structure)
                <div class="bg-gray-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-indigo-500 transition">
                    <div class="relative">
                        @if($structure->photo)
                            <img src="{{ Storage::url($structure->photo) }}" 
                                 alt="{{ $structure->name }}"
                                 class="w-full h-64 object-cover">
                        @else
                            <div class="w-full h-64 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                <svg class="w-24 h-24 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif
                        
                        @if(!$structure->is_active)
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 text-xs rounded bg-red-500 text-white">Inactive</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-4">
                        <div class="mb-3">
                            <span class="text-xs text-indigo-400 font-medium">Order: {{ $structure->order }}</span>
                            <h3 class="text-white font-bold text-lg">{{ $structure->position }}</h3>
                            <p class="text-gray-300 text-base mt-1">{{ $structure->name }}</p>
                        </div>
                        
                        @if($structure->phone)
                            <p class="text-gray-400 text-sm mb-3">
                                📱 {{ $structure->phone }}
                            </p>
                        @endif
                        
                        <div class="flex gap-2 pt-3 border-t border-gray-700">
                            <a href="{{ route('admin.structure.edit', $structure) }}"
                                class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm">
                                Edit
                            </a>
                            <form action="{{ route('admin.structure.destroy', $structure) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Are you sure?')"
                                  class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-400 py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-xl">No structure positions added yet.</p>
                </div>
            @endforelse
        </div>

        @if($structures->isNotEmpty())
            <div class="mt-6 text-gray-400 text-sm">
                Showing {{ $structures->count() }} position(s)
            </div>
        @endif
    </div>
</x-layout>