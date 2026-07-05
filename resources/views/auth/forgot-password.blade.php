@extends('layout')

@section('content')

    <div style="max-width: 500px; margin: 40px auto;">

        <h1 style="margin-bottom: 10px;">Forgot Password</h1>
        <p style="margin-bottom: 20px; color: gray;">
            Enter your email and we’ll send you a reset link
        </p>

        {{-- status message --}}
        @if(session('status'))
            <div class="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>

            @error('email')
            <div style="color:red; font-size:13px;">{{ $message }}</div>
            @enderror

            <div style="margin-top: 20px; display:flex; justify-content:flex-end;">
                <button type="submit" class="btn">
                    Send Reset Link
                </button>
            </div>

        </form>

    </div>

@endsection
