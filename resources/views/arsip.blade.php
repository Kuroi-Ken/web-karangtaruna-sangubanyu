{{-- resources/views/arsip.blade.php --}}
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <link rel="icon" type="image/png" href="{{ asset('assets/kartur.png') }}">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full">
    <div class="min-h-full">
        <x-navbar></x-navbar>
        <x-header>{{ $title }}</x-header>
        
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    <div class="py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                Arsip Karang Taruna
            </h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Akses dokumen dan laporan resmi Karang Taruna Desa Sangubanyu
            </p>
        </div>

        <!-- Navigation Tabs -->
        <div class="max-w-4xl mx-auto mb-8">
            <div class="bg-gray-800 rounded-xl p-2 flex gap-2">
                <a href="/arsip/laporan-keuangan" 
                   class="{{ request()->is('arsip/laporan-keuangan*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} flex-1 text-center px-6 py-3 rounded-lg font-semibold transition">
                    <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                    </svg>
                    Laporan Keuangan
                </a>
                <a href="/arsip/dokumen" 
                   class="{{ request()->is('arsip/dokumen*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} flex-1 text-center px-6 py-3 rounded-lg font-semibold transition">
                    <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                    </svg>
                    Arsip Surat & Laporan
                </a>
            </div>
        </div>

            <!-- Content Area -->
            <div class="max-w-6xl mx-auto">
                @yield('arsip-content')
            </div>
        </div>
            </div>
        </main>
    </div>
    <x-footer></x-footer>
</body>

</html>