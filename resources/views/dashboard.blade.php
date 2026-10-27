<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Account | United Universe Express LLC</title>
<style>
    :root { --brand:#0f5132; --brand-2:#157347; --bg:#f3f5f4; }
    body { margin:0; font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; background:var(--bg); color:#1b1b1b; }
    .top { background:#fff; box-shadow:0 1px 3px rgba(0,0,0,.06); padding:14px 24px; display:flex; align-items:center; gap:14px; }
    .top a.brand { color:var(--brand); font-weight:800; text-decoration:none; font-size:1.05rem; }
    .top .sp { flex:1; }
    .btn { background:var(--brand); color:#fff; border:0; border-radius:8px; padding:9px 16px; font-weight:600; text-decoration:none; cursor:pointer; display:inline-block; }
    .btn.ghost { background:#fff; color:var(--brand); border:1px solid #d7ddd9; }
    .wrap { max-width:860px; margin:40px auto; padding:0 20px; }
    .card { background:#fff; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,.05); padding:32px; }
    h1 { margin:0 0 6px; }
    .muted { color:#6b7280; }
    .grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:16px; margin-top:24px; }
    .tile { border:1px solid #eef0ef; border-radius:12px; padding:20px; text-decoration:none; color:inherit; }
    .tile:hover { border-color:var(--brand-2); }
    .tile h3 { margin:0 0 4px; font-size:1.05rem; }
</style>
</head>
<body>
<div class="top">
    <a href="{{ route('home') }}" class="brand">United Universe Express</a>
    <div class="sp"></div>
    <span class="muted">{{ auth()->user()->name }}</span>
    <form method="POST" action="{{ route('logout') }}">@csrf <button class="btn ghost">Log Out</button></form>
</div>
<div class="wrap">
    <div class="card">
        <h1>Welcome, {{ auth()->user()->name }}</h1>
        <p class="muted">This is your account area. More features (your bookings, subscriptions, and orders) are coming soon.</p>
        <div class="grid">
            <a href="{{ route('services.index') }}" class="tile">
                <h3>Book a Delivery</h3>
                <p class="muted" style="margin:0;">Browse services and request a pickup.</p>
            </a>
            <a href="{{ route('shop') }}" class="tile">
                <h3>Shop Supplies</h3>
                <p class="muted" style="margin:0;">Packing kits and freight gear.</p>
            </a>
            <a href="{{ route('contact') }}" class="tile">
                <h3>Contact Us</h3>
                <p class="muted" style="margin:0;">Questions? Reach our team.</p>
            </a>
        </div>
    </div>
</div>
</body>
</html>
