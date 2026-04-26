<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','SIMS Admin') â€” SMA MA'ARIF KROYA</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
@stack('styles')
</head>
<body>
@yield('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
<script src="{{ asset('js/admin.js') }}?v={{ filemtime(public_path('js/admin.js')) }}"></script>
<script src="{{ asset('js/admin-rbac.js') }}?v={{ filemtime(public_path('js/admin-rbac.js')) }}"></script>
@stack('scripts')
</body>
</html>
