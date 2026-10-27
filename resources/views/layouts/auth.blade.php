<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Account') | United Universe Express LLC</title>
<style>
    :root { --brand:#0f5132; --brand-2:#157347; --ink:#1b1b1b; --muted:#6b7280; --line:#e5e7eb; --bg:#f3f5f4; }
    * { box-sizing:border-box; }
    body { margin:0; font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif; background:var(--bg); color:var(--ink); display:flex; min-height:100vh; align-items:center; justify-content:center; padding:24px; }
    .auth-card { background:#fff; width:100%; max-width:420px; border-radius:16px; box-shadow:0 10px 40px rgba(0,0,0,.08); padding:36px 32px; }
    .auth-brand { text-align:center; margin-bottom:22px; }
    .auth-brand a { text-decoration:none; color:var(--brand); font-weight:800; font-size:1.25rem; letter-spacing:.3px; }
    .auth-brand small { display:block; color:var(--muted); font-weight:500; font-size:.8rem; margin-top:4px; }
    h1 { font-size:1.4rem; margin:0 0 4px; }
    .sub { color:var(--muted); font-size:.9rem; margin:0 0 20px; }
    label { display:block; font-size:.82rem; font-weight:600; margin:14px 0 6px; }
    input[type=text],input[type=email],input[type=password] { width:100%; padding:11px 13px; border:1px solid var(--line); border-radius:9px; font-size:.95rem; outline:none; }
    input:focus { border-color:var(--brand-2); box-shadow:0 0 0 3px rgba(21,115,71,.12); }
    .btn { width:100%; margin-top:20px; background:var(--brand); color:#fff; border:0; border-radius:9px; padding:12px; font-size:.98rem; font-weight:700; cursor:pointer; }
    .btn:hover { background:var(--brand-2); }
    .row { display:flex; align-items:center; justify-content:space-between; margin-top:14px; font-size:.85rem; }
    .row a { color:var(--brand-2); text-decoration:none; }
    .muted-link { text-align:center; margin-top:18px; font-size:.88rem; color:var(--muted); }
    .muted-link a { color:var(--brand-2); text-decoration:none; font-weight:600; }
    .check { display:flex; align-items:center; gap:7px; font-weight:500; font-size:.85rem; color:var(--muted); }
    .alert { background:#fde8e8; color:#9b1c1c; border-radius:9px; padding:10px 12px; font-size:.85rem; margin-bottom:14px; }
    .alert-ok { background:#e6f4ea; color:#0f5132; }
    .err { color:#9b1c1c; font-size:.78rem; margin-top:5px; }
</style>
</head>
<body>
<div class="auth-card">
    <div class="auth-brand">
        <a href="{{ route('home') }}">United Universe Express</a>
        <small>Albany Courier Services</small>
    </div>

    @if (session('status'))
        <div class="alert alert-ok">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert">{{ $errors->first() }}</div>
    @endif

    @yield('content')
</div>
</body>
</html>
