<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SMA MA\'ARIF KROYA — Sistem Informasi Sekolah')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', config('school.meta.description'))">
    <meta name="keywords"    content="@yield('meta_keywords', config('school.meta.keywords'))">
    <meta name="author"      content="{{ config('school.meta.author') }}">

    <!-- Open Graph -->
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:title"       content="@yield('title', config('school.name'))">
    <meta property="og:description" content="@yield('meta_description', config('school.meta.description'))">
    <meta property="og:image"       content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter Card -->
    <meta property="twitter:card"        content="summary_large_image">
    <meta property="twitter:url"         content="{{ url()->current() }}">
    <meta property="twitter:title"       content="@yield('title', config('school.name'))">
    <meta property="twitter:description" content="@yield('meta_description', config('school.meta.description'))">
    <meta property="twitter:image"       content="{{ asset('images/og-image.jpg') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

    @stack('styles')
</head>
<body>
    <style>
        :root {
            --green: #1B6B3A;
            --green2: #22854A;
            --green-light: #2DAF60;
            --gold: #C9932A;
            --gold2: #E5A830;
            --navy: #0F1F14;
            --cream: #F8F5EF;
            --white: #FFFFFF;
            --text: #1A2E1F;
            --muted: #6B7E70;
            --border: rgba(27,107,58,0.15);
        }
    </style>

    @yield('content')

    <!-- Main JS -->
    <script src="{{ asset('js/landing.js') }}"></script>
    @stack('scripts')
</body>
</html>
