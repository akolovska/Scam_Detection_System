@extends('layout')

@section('content')

    <div style="max-width: 500px; margin: 40px auto;">

        <h1 style="margin-bottom: 10px;" class="text-lg font-semibold">Register</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name --}}
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>

            @error('name')
            <div style="color:red; font-size:13px;">{{ $message }}</div>
            @enderror

            {{-- Email --}}
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>

            @error('email')
            <div style="color:red; font-size:13px;">{{ $message }}</div>
            @enderror

            {{-- Password --}}
            <label>Password</label>
            <input type="password" name="password" required>

            @error('password')
            <div style="color:red; font-size:13px;">{{ $message }}</div>
            @enderror

            {{-- Confirm Password --}}
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>

            @error('password_confirmation')
            <div style="color:red; font-size:13px;">{{ $message }}</div>
            @enderror

            <div style="margin-top: 20px; display:flex; justify-content:space-between; align-items:center;">

                <a href="{{ route('login') }}">Already registered?</a>

                <button type="submit" class="btn">
                    Register
                </button>

            </div>

        </form>

    </div>

@endsection
