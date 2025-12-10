@props(['hideHeader' => false, 'hideNavbar' => false])

<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <link rel="icon" type="image/png" href="{{ asset('assets/kartur.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('kartur.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('kartur.png') }}">
    
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }
        .sticky-offset {
            scroll-margin-top: 100px;
        }
    </style>
</head>

<body class="h-full">
    <div class="min-h-full">

        @if (!($hideNavbar ?? false))
            <x-navbar></x-navbar>
        @endif

        @if (!($hideHeader ?? false))
            <x-header>{{ $title }}</x-header>
        @endif

        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>
