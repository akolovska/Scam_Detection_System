@extends('layout')

@section('content')

    <div style="max-width: 500px; margin: 40px auto;">

        <h1 style="margin-bottom: 10px;" class="text-lg font-semibold">Login</h1>


        @if(session('status'))
            <div class="alert">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">

            @csrf

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>

            @error('email')
            <div style="color:red; font-size:13px;">{{ $message }}</div>
            @enderror

            <label>Password</label>
            <input type="password" name="password" required>

            @error('password')
            <div style="color:red; font-size:13px;">{{ $message }}</div>
            @enderror

            <div style="margin-top: 10px;">
                <label style="display:flex; align-items:center; gap:6px; font-size:13px;">
                    <input type="checkbox" name="remember" style="width:14px; height:14px; margin:0;">
                    <span>Remember me</span>
                </label>
            </div>

            <div style="margin-top: 20px; display:flex; gap:10px; justify-content:space-between; align-items:center;">

                <div>
                    <a href="{{ route('register') }}">Register</a>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"> Forgot password</a>
                    @endif
                </div>

                <button type="submit" class="btn">
                    Login
                </button>

            </div>

        </form>

    </div>

@endsection
