<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Sewa Motor Balap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary-color: #667eea;
            --primary-dark: #5568d3;
            --secondary-color: #764ba2;
            --sidebar-bg: #2d3748;
            --sidebar-hover: #4a5568;
            --topbar-bg: #ffffff;
            --content-bg: #f7fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body { 
            background-color: var(--content-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .admin-wrapper { 
            display: flex; 
            min-height: 100vh; 
        }

        /* Sidebar Styles */
        .sidebar { 
            width: 260px; 
            background: var(--sidebar-bg);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: sticky; 
            top: 0; 
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        .brand { 
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: #fff; 
            padding: 20px;
            font-weight: 700; 
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .brand i {
            font-size: 1.5rem;
        }

        .nav-section-title { 
            color: #a0aec0;
            font-size: 0.7rem; 
            padding: 20px 20px 8px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .side-link { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 12px 20px; 
            color: #e2e8f0;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            position: relative;
        }

        .side-link:hover { 
            background: var(--sidebar-hover);
            color: #ffffff;
            padding-left: 24px;
        }

        .side-link.active { 
            background: var(--sidebar-hover);
            border-left-color: var(--primary-color);
            color: #ffffff;
        }

        .side-link.active::before {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--primary-color);
        }

        .side-link i { 
            width: 20px; 
            text-align: center;
            font-size: 1.1rem;
        }

        .side-link:hover i,
        .side-link.active i {
            transform: scale(1.1);
            color: var(--primary-color);
        }

        /* Logout Button Special Style */
        .side-link.logout-btn {
            margin-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
        }

        .side-link.logout-btn:hover {
            background: #e53e3e;
            color: white;
        }

        .side-link.logout-btn:hover i {
            color: white;
        }

        /* Content Area */
        .content { 
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Topbar Styles */
        .topbar { 
            background: var(--topbar-bg);
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-title i {
            color: var(--primary-color);
        }

        .topbar .user { 
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 25px;
            color: white;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .topbar .user:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .topbar .user i { 
            font-size: 1.3rem;
        }

        .topbar .user span {
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 24px;
        }

        /* Footer */
        .footer { 
            background: white;
            color: #718096;
            font-size: 0.85rem;
            padding: 16px 24px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            margin-top: auto;
        }

        /* Scrollbar for main content */
        .content::-webkit-scrollbar {
            width: 8px;
        }

        .content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .content::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }

        .content::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Badge for notifications */
        .badge-notification {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #e53e3e;
            color: white;
            font-size: 0.65rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            
            .sidebar.active {
                width: 260px;
            }

            .topbar-title {
                font-size: 1rem;
            }

            .topbar .user span {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand">
            <i class="fas fa-motorcycle"></i>
            <span>Sewa Motor Admin</span>
        </div>

        <div class="nav-section-title">
            <i class="fas fa-home"></i> Dashboard
        </div>
        <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>

        <div class="nav-section-title">
            <i class="fas fa-cog"></i> Management
        </div>
        <a class="side-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
            <i class="fas fa-users"></i>
            <span>Users</span>
        </a>
        <a class="side-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
            <i class="fas fa-tags"></i>
            <span>Kategori</span>
        </a>
        <a class="side-link {{ request()->routeIs('admin.motors.*') ? 'active' : '' }}" href="{{ route('admin.motors.index') }}">
            <i class="fas fa-motorcycle"></i>
            <span>Unit Motor</span>
        </a>
        <a class="side-link {{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}" href="{{ route('admin.rentals.active') }}">
            <i class="fas fa-clock"></i>
            <span>Sewa Aktif</span>
            @if(isset($activeRentals) && $activeRentals > 0)
                <span class="badge-notification">{{ $activeRentals }}</span>
            @endif
        </a>

        <div class="nav-section-title">
            <i class="fas fa-user"></i> Account
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="side-link logout-btn w-100 text-start" style="background:none; border:none; cursor:pointer;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-title">
                <i class="fas fa-chart-line"></i>
                <span>@yield('title', 'Admin Panel')</span>
            </div>
            <div class="user">
                <i class="fas fa-user-circle"></i>
                <span>{{ Auth::user()->name ?? 'Administrator' }}</span>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>
                <i class="fas fa-copyright"></i>
                {{ date('Y') }} <strong>Sewa Motor Balap</strong> - Admin Panel
            </div>
            <div class="mt-1">
                <small>Built with <i class="fas fa-heart text-danger"></i> using Laravel & Bootstrap</small>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>