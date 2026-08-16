<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scam Detection System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
        }

        .navbar {
            background: #111827;
            color: white;
            padding: 14px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 12px;
            font-weight: 500;
        }

        .navbar a:hover {
            opacity: 0.8;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            background: white;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .btn {
            padding: 8px 14px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f9fafb;
            font-size: 14px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 14px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
        }

        .alert {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .welcome {
            opacity: 0.9;
            font-size: 14px;
        }
        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            background: #374151;
            color: white;
            border: 1px solid #4b5563;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 12px;
            transition: background 0.2s, border-color 0.2s;
        }

        .profile-btn:hover {
            background: #4b5563;
            border-color: #6b7280;
        }

        .profile-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 42px;
            background: white;
            min-width: 140px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            overflow: hidden;
            z-index: 1000;
        }

        .profile-menu.show {
            display: block;
        }

        .profile-menu a,
        .profile-menu button {
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 10px 14px;
            margin: 0;
            border: none;
            background: white;
            color: #111827;
            text-align: left;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .profile-menu a:hover,
        .profile-menu button:hover {
            background: #f3f4f6;
        }

        .profile-menu button {
            color: #dc2626;
        }
    </style>
</head>

<script>
    function toggleProfileMenu() {
        document.getElementById('profile-menu').classList.toggle('show');
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('.profile-dropdown');

        if (!dropdown.contains(event.target)) {
            document.getElementById('profile-menu').classList.remove('show');
        }
    });
</script>

<body>

<div class="navbar">

    <div>
        <a href="{{ route('reports.index') }}">Reports</a>
    </div>

    <div class="nav-right">

        @auth

            <span class="welcome">
                Welcome, {{ auth()->user()->name }}
            </span>
            <a href="{{ route('reports.index') }}">Reports</a>
            <a href="{{ route('statistics') }}">Statistics</a>
            <a href="{{ route('reports.mine') }}">My Reports</a>
            <div class="profile-dropdown">
                <button type="button" class="profile-btn" onclick="toggleProfileMenu()">
                    Profile ▾
                </button>

                <div id="profile-menu" class="profile-menu">
                    <a href="{{ route('profile.edit') }}">Profile</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>

        @else
            <a href="{{ route('register') }}">Register</a>
            <a href="{{ route('login') }}" class="btn">
                Login
            </a>

        @endauth

    </div>

</div>

<div class="container">

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')

</div>

</body>
</html>
