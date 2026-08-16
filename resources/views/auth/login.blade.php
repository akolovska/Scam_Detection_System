@extends('layout')

@section('content')

    <div class="max-w-[500px] mx-auto mt-10">

        <h1 class="text-lg font-semibold mb-4">Login</h1>

        @if(session('status'))
            <div class="alert mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block mb-1 text-sm font-medium text-gray-900">
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full px-3 py-2 border border-gray-300 rounded-md
                           focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >

                @error('email')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block mb-1 text-sm font-medium text-gray-900">
                    Password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md
                           focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >

                @error('password')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input
                    type="checkbox"
                    name="remember"
                    class="w-4 h-4 rounded border-gray-300"
                >
                <span>Remember me</span>
            </label>

            <div class="mt-5 flex justify-between items-center">

                <div class="flex gap-3 text-sm">
                    <a
                        href="{{ route('register') }}"
                        class="text-gray-600 hover:text-gray-900 underline"
                    >
                        Register
                    </a>

                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-gray-600 hover:text-gray-900 underline"
                        >
                            Forgot password
                        </a>
                    @endif
                </div>

                <button
                    type="submit"
                    class="px-4 py-2 bg-gray-900 text-white text-sm rounded-md
                           hover:bg-gray-700 transition"
                >
                    Login
                </button>

            </div>

        </form>

    </div>

@endsection
