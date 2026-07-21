@props(['title' => 'Welcome'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Networx Solutions provides reliable IT support, networking, cloud, cybersecurity, CCTV, and Microsoft 365 services for growing businesses.">
    <meta name="theme-color" content="#ffffff">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">
    <title>{{ $title }} · Networx Solutions</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|manrope:500,600,700,800" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-full bg-white font-sans text-slate-900 antialiased">
    {{ $slot }}

    <x-flash />
</body>

</html>
