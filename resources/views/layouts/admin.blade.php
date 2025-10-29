<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sewa Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f5f6f8; }
        .admin-wrapper { display: flex; min-height: 100vh; }
        .sidebar { width: 240px; background: #ffffff; border-right: 1px solid #e6e6e6; position: sticky; top: 0; height: 100vh; }
        .brand { background: #4b0037; color: #fff; padding: 16px 20px; font-weight: 700; letter-spacing: .3px; }
        .nav-section-title { color: #999; font-size: .76rem; padding: 12px 20px 6px; text-transform: uppercase; }
        .side-link { display: flex; align-items: center; gap: 10px; padding: 10px 16px; color: #333; text-decoration: none; border-left: 3px solid transparent; }
        .side-link:hover, .side-link.active { background: #f1eef5; border-left-color: #4b0037; }
        .side-link i { width: 18px; text-align: center; color: #4b0037; }
        .content { flex: 1; padding: 24px; }
        .topbar { background: #ffffff; border-bottom: 1px solid #e6e6e6; padding: 10px 16px; display:flex; justify-content: space-between; align-items:center; }
        .topbar .user { display:flex; align-items:center; gap:8px; }
        .topbar .user i { color:#4b0037; }
        .footer { color:#888; font-size:.9rem; padding: 16px; text-align:center; }
    </style>
    @stack('styles')
</head>
<body>
<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="brand">Admin Dashboard</div>
        <div class="nav-section-title">Dashboard</div>
        <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="fa-regular fa-gauge-high"></i> <span>Dashboard</span>
        </a>

        <div class="nav-section-title">Management</div>
        <a class="side-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
            <i class="fa-regular fa-users"></i> <span>Users</span>
        </a>
        <a class="side-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
            <i class="fa-regular fa-tags"></i> <span>Kategori</span>
        </a>
        <a class="side-link {{ request()->routeIs('admin.motors.*') ? 'active' : '' }}" href="{{ route('admin.motors.index') }}">
            <i class="fa-regular fa-motorcycle"></i> <span>Unit Motor</span>
        </a>
        <a class="side-link {{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}" href="{{ route('admin.rentals.active') }}">
            <i class="fa-regular fa-clock"></i> <span>Sewa Aktif</span>
        </a>

        <div class="nav-section-title">Account</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="side-link w-100 text-start" style="background:none; border:none;">
                <i class="fa-regular fa-right-from-bracket"></i> <span>Logout</span>
            </button>
        </form>
    </aside>

    <main class="content">
        <div class="topbar">
            <div>
                <strong>@yield('title', 'Admin')</strong>
            </div>
            <div class="user">
                <i class="fa-regular fa-circle-user"></i>
                <span>{{ Auth::user()->name ?? 'Admin' }}</span>
            </div>
        </div>

        <div class="mt-3">
            @yield('content')
        </div>

        <div class="footer">&copy; {{ date('Y') }} Sewa Motor</div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
