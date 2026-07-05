@extends('layout')

@section('content')

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="margin:0;">Profile Settings</h1>
            <p style="margin:5px 0 0; color:gray;">
                Manage your account, password and security settings
            </p>
        </div>
    </div>

    <div style="display:flex; flex-direction:column; gap:20px; align-items:flex-start;">

        <div class="container" style="margin:0; text-align:left;">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="container" style="margin:0; text-align:left;">
            @include('profile.partials.update-password-form')
        </div>

        <div class="container" style="border:1px solid #fca5a5;">
            @include('profile.partials.delete-user-form')
        </div>

    </div>

@endsection
