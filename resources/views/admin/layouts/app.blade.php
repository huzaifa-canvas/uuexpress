<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    // Apply saved theme before paint to avoid a flash.
    (function () {
        try { document.documentElement.setAttribute('data-bs-theme', localStorage.getItem('uuAdminTheme') || 'light'); } catch (e) {}
    })();
</script>
<title>@yield('title', 'Dashboard') · UU Express Admin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/uu-ui.css') }}?v={{ @filemtime(public_path('assets/css/uu-ui.css')) }}">
<script src="{{ asset('assets/js/uu-ui.js') }}?v={{ @filemtime(public_path('assets/js/uu-ui.js')) }}"></script>
<style>
    :root { --brand:#0f5132; --brand-2:#157347; --sidebar:#0b2e20; --sidebar-ink:#cfe6db; --bg:#f4f6f5; }
    body { background:var(--bg); font-family:"Public Sans",system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; }
    .admin-wrap { display:flex; min-height:100vh; }
    .sidebar { width:256px; background:var(--sidebar); color:var(--sidebar-ink); flex-shrink:0; position:fixed; inset:0 auto 0 0; display:flex; flex-direction:column; transition:transform .25s; z-index:1040; }
    .sidebar__brand { padding:20px 22px; font-weight:800; color:#fff; font-size:1.1rem; letter-spacing:.3px; display:flex; align-items:center; gap:10px; border-bottom:1px solid rgba(255,255,255,.07); }
    .sidebar__brand i { color:#4ade80; }
    .sidebar__nav { padding:14px 12px; overflow-y:auto; flex:1; }
    .sidebar__label { font-size:.68rem; text-transform:uppercase; letter-spacing:.09em; color:rgba(255,255,255,.4); margin:16px 12px 8px; }
    .sidebar__nav a { display:flex; align-items:center; gap:11px; padding:10px 14px; border-radius:9px; color:var(--sidebar-ink); text-decoration:none; font-size:.92rem; font-weight:500; margin-bottom:2px; }
    .sidebar__nav a:hover { background:rgba(255,255,255,.07); color:#fff; }
    .sidebar__nav a.active { background:var(--brand-2); color:#fff; box-shadow:0 4px 12px rgba(21,115,71,.4); }
    .sidebar__nav a.disabled { opacity:.45; pointer-events:none; }
    .sidebar__nav a .badge { margin-left:auto; font-size:.6rem; }
    .main { flex:1; margin-left:256px; display:flex; flex-direction:column; min-width:0; }
    .topbar { background:#fff; height:62px; display:flex; align-items:center; gap:14px; padding:0 22px; box-shadow:0 1px 3px rgba(0,0,0,.05); position:sticky; top:0; z-index:1030; }
    .topbar h1 { font-size:1.05rem; margin:0; font-weight:700; }
    .topbar .spacer { flex:1; }
    .content { padding:26px; }
    .stat-card { border:0; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.05); }
    .stat-card .icon { width:46px; height:46px; border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; }
    .card { border:0; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.05); }
    .table > :not(caption) > * > * { padding:.7rem .75rem; }
    .btn-brand { background:var(--brand); color:#fff; } .btn-brand:hover { background:var(--brand-2); color:#fff; }
    .menu-backdrop { display:none; }
    @media (max-width: 991px) {
        .sidebar { transform:translateX(-100%); }
        .sidebar.open { transform:translateX(0); }
        .main { margin-left:0; }
        .menu-backdrop.show { display:block; position:fixed; inset:0; background:rgba(0,0,0,.4); z-index:1035; }
    }
    /* Dark mode (Bootstrap data-bs-theme handles components; these cover custom chrome) */
    html[data-bs-theme="dark"] { --bg:#0e1512; --sidebar:#0a1711; }
    html[data-bs-theme="dark"] .topbar { background:#161e1a; box-shadow:0 1px 3px rgba(0,0,0,.5); }
    html[data-bs-theme="dark"] .topbar h1 { color:#e8edeb; }
    html[data-bs-theme="dark"] .stat-card, html[data-bs-theme="dark"] .card { box-shadow:0 2px 10px rgba(0,0,0,.4); }
</style>
@stack('head')
</head>
<body>
<div class="admin-wrap">
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar__brand">
            <i class="bi bi-box-seam-fill"></i> UU Express
        </div>
        <nav class="sidebar__nav">
            <div class="sidebar__label">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Services</a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="bi bi-bag"></i> Products</a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="bi bi-receipt"></i> Orders</a>
            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"><i class="bi bi-calendar-check"></i> Bookings</a>
            <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"><i class="bi bi-chat-left-text"></i> Contact Us</a>
        </nav>
    </aside>
    <div class="menu-backdrop" id="menuBackdrop"></div>

    <div class="main">
        <header class="topbar">
            <button class="btn btn-sm btn-light d-lg-none" id="menuToggle"><i class="bi bi-list"></i></button>
            <h1>@yield('title', 'Dashboard')</h1>
            <div class="spacer"></div>
            <button class="btn btn-sm btn-light" id="themeToggle" title="Toggle dark mode"><i class="bi bi-moon-stars"></i></button>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-box-arrow-up-right"></i> View Site</a>
            <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="bi bi-person-gear"></i> My Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit"><i class="bi bi-box-arrow-right"></i> Log Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <main class="content">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle"></i> {{ session('status') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        var sb = document.getElementById('adminSidebar');
        var bd = document.getElementById('menuBackdrop');
        var tg = document.getElementById('menuToggle');
        function toggle(open){ sb.classList.toggle('open', open); bd.classList.toggle('show', open); }
        if (tg) tg.addEventListener('click', function(){ toggle(!sb.classList.contains('open')); });
        if (bd) bd.addEventListener('click', function(){ toggle(false); });

        // Dark mode toggle
        var tt = document.getElementById('themeToggle');
        function syncIcon(){
            var dark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            if (tt) tt.querySelector('i').className = dark ? 'bi bi-sun' : 'bi bi-moon-stars';
        }
        syncIcon();
        if (tt) tt.addEventListener('click', function(){
            var next = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', next);
            try { localStorage.setItem('uuAdminTheme', next); } catch (e) {}
            syncIcon();
        });
    })();
</script>
@stack('scripts')
</body>
</html>
