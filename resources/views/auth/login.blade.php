<x-layout :hideNavbar="true">
    <x-slot:title>Admin Login</x-slot:title>

    <div class="flex min-h-[calc(100vh-16rem)] items-center justify-center">
        <div class="w-full max-w-md">
            <div class="bg-gray-800 rounded-lg shadow-xl p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Admin Login</h2>
                    <p class="text-gray-400 text-sm">Access to admin panel only</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-white mb-2 font-medium text-sm">Email Address</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}" 
                               placeholder="admin@example.com"
                               required 
                               autofocus
                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition placeholder-gray-500">
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-white mb-2 font-medium text-sm">Password</label>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               placeholder="••••••••"
                               required
                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition placeholder-gray-500">
                    </div>

                    <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition duration-200">
                        Login as Admin
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="/" class="text-sm text-gray-400 hover:text-white transition">
                        ← Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>