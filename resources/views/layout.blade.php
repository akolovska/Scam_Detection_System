<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scam Detection System</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
body {
    font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f6fa;
        }

        .navbar {
    background: #1f2937;
    color: white;
    padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
    color: white;
    margin-left: 15px;
            text-decoration: none;
        }

        .container {
    max-width: 1000px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        .btn {
    padding: 8px 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-danger {
    background: #dc2626;
}

table {
    width: 100%;
    border-collapse: collapse;
        }

        table th, table td {
    border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
    background: #f3f4f6;
}

input, textarea, select {
    width: 100%;
    padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .alert {
    padding: 10px;
            background: #d1fae5;
            color: #065f46;
            margin-bottom: 15px;
            border-radius: 5px;
        }

    </style>
</head>

<body>

<div class="navbar">

    <a href="{{ route('reports.index') }}">Reports</a>

    <div style="margin-left:auto; display:flex; align-items:center; gap:15px;">

        @auth



            <span>
                Welcome, {{ auth()->user()->name }}
            </span>
            @if(auth()->user()->role === \App\Enums\UserRole::ADMIN)
                <a href="{{ route('reports.create') }}">Create Report</a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn">
                    Logout
                </button>
            </form>

        @else

            <a href="{{ route('login') }}">Login</a>

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
