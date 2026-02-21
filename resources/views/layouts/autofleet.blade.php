<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'AutoFleet')</title>

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-dark: #0a0e27;
            --bg-card: #141b3a;
            --bg-sidebar: #0f1429;
            --accent-primary: #00d4ff;
            --accent-secondary: #7c3aed;
            --accent-success: #10b981;
            --accent-warning: #f59e0b;
            --accent-danger: #ef4444;
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --border-color: #1e293b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background:
                radial-gradient(circle at 20% 50%, rgba(0, 212, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(124, 58, 237, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .nav-menu { padding: 1.5rem 0; }

        .nav-item {
            padding: 0.875rem 1.5rem;
            margin: 0.25rem 0.75rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--text-secondary);
            font-weight: 600;
            text-decoration: none;
        }

        .nav-item:hover {
            background: rgba(0, 212, 255, 0.1);
            color: var(--accent-primary);
            transform: translateX(4px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.15), rgba(124, 58, 237, 0.15));
            color: var(--text-primary);
            border-left: 3px solid var(--accent-primary);
        }

        .nav-item i { font-size: 1.125rem; width: 24px; }

        /* Main */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 2rem;
            width: calc(100% - 280px);
        }

        /* Header */
        .header {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 1.75rem 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .header-left h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--text-primary), var(--accent-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-left p { color: var(--text-secondary); font-size: 0.95rem; }

        .header-right { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background: rgba(255,255,255,0.02);
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.125rem;
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.15);
            color: var(--accent-danger);
            border: 1px solid rgba(239, 68, 68, 0.35);
            padding: 0.65rem 1rem;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 800;
            font-family: 'Outfit', sans-serif;
            transition: transform 0.2s ease;
        }
        .btn-logout:hover { transform: translateY(-1px); }

        /* ====== TABLE / BUTTONS / BADGES (IMPORTANT) ====== */
        .table-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 1.5rem;
            overflow-x: auto;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .table-title {
            font-size: 1.2rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: .7rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            color: white;
            border: none;
            padding: .75rem 1.1rem;
            border-radius: 12px;
            font-weight: 800;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            transition: transform .2s ease;
        }

        .btn-primary:hover { transform: translateY(-1px); }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
        }

        thead { border-bottom: 1px solid var(--border-color); }

        th {
            text-align: left;
            padding: 1rem;
            color: var(--text-secondary);
            font-weight: 700;
            font-size: .85rem;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        tr:hover { background: rgba(0, 212, 255, 0.05); }

        .badge {
            padding: .45rem .9rem;
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 700;
            display: inline-block;
        }

        .badge.disponible { background: rgba(16,185,129,0.15); color: var(--accent-success); }
        .badge.en_service { background: rgba(0,212,255,0.15); color: var(--accent-primary); }
        .badge.en_panne { background: rgba(239,68,68,0.15); color: var(--accent-danger); }

        .actions { display: flex; gap: .5rem; align-items: center; }

        .btn-action {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.03);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: transform .15s ease;
        }

        .btn-action:hover { transform: scale(1.06); }

        .btn-action.view { color: var(--accent-primary); }
        .btn-action.edit { color: var(--accent-success); }
        .btn-action.delete { color: var(--accent-danger); }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; width: 100%; }
        }
    </style>
</head>

<body>
<div class="dashboard-container">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <div class="logo-icon"><i class="fas fa-car"></i></div>
                <span>AutoFleet</span>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('vehicles.index') }}"
               class="nav-item {{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
                <i class="fas fa-car"></i>
                <span>Véhicules</span>
            </a>

            <a href="{{ route('reservations.index') }}"
               class="nav-item {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Réservations</span>
            </a>

            @if(auth()->user()?->role === 'admin')
                <a href="{{ route('clients.index') }}"
                   class="nav-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Clients</span>
                </a>
            @endif
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <h1>@yield('page_title', 'Dashboard')</h1>
                <p>@yield('page_subtitle', "Vue d'ensemble")</p>
            </div>

            <div class="header-right">
                @php
                    $name = auth()->user()->name ?? 'Utilisateur';
                    $email = auth()->user()->email ?? '';
                    $initials = collect(explode(' ', trim($name)))
                        ->filter()
                        ->map(fn($w) => strtoupper(substr($w,0,1)))
                        ->take(2)
                        ->join('');
                    if ($initials === '') { $initials = 'U'; }
                    $role = auth()->user()->role ?? 'client';
                @endphp

                <div class="user-profile">
                    <div class="user-avatar">{{ $initials }}</div>
                    <div>
                        <div style="font-weight: 800;">{{ $name }}</div>
                        <div style="font-size: 0.875rem; color: var(--text-secondary);">
                            {{ $email }} — {{ strtoupper($role) }}
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        @yield('content')
    </main>
</div>

@yield('scripts')
</body>
</html>
