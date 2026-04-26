<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SMA MA'ARIF KROYA</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box} body{margin:0;font-family:'Plus Jakarta Sans',sans-serif;background:linear-gradient(135deg,#0f1f14,#1b6b3a 55%,#f8f5ef);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;color:#111827}
        .card{width:100%;max-width:420px;background:rgba(255,255,255,.95);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.35);border-radius:24px;padding:32px;box-shadow:0 24px 80px rgba(0,0,0,.24)}
        .badge{display:inline-flex;align-items:center;gap:8px;background:#f0fdf4;color:#1b6b3a;border-radius:999px;padding:6px 12px;font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase}
        h1{font-family:Syne, sans-serif;font-size:1.8rem;margin:16px 0 8px;color:#0f1f14}
        p{margin:0 0 20px;color:#6b7280;font-size:.95rem;line-height:1.6}
        label{display:block;font-size:.8rem;font-weight:700;margin:0 0 6px;color:#374151}
        input{width:100%;padding:12px 14px;border:1px solid #e5e7eb;border-radius:12px;font-size:.95rem;outline:none}
        input:focus{border-color:#1b6b3a;box-shadow:0 0 0 3px rgba(27,107,58,.12)}
        .btn{width:100%;margin-top:12px;padding:12px 16px;border:none;border-radius:12px;background:linear-gradient(135deg,#1b6b3a,#22854a);color:white;font-weight:800;cursor:pointer}
        .error{background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;border-radius:12px;padding:10px 12px;font-size:.9rem;margin-bottom:14px}
        .meta{margin-top:16px;font-size:.8rem;color:#6b7280}
    </style>
</head>
<body>
    <div class="card">
        <div class="badge">Admin Panel</div>
        <h1>Masuk ke Dashboard</h1>
        <p>Gunakan akun admin untuk mengelola data sekolah, PPDB, dan modul internal.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <div style="margin-bottom:14px;">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div style="margin-bottom:4px;">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Masuk</button>
        </form>

        <div class="meta">
            Demo admin: <strong>admin@smamaarifkroya.sch.id</strong> / <strong>password123</strong>
        </div>
    </div>
</body>
</html>
