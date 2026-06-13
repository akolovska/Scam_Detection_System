@extends('layout')

@section('content')

    <h1>Submit Scam Report</h1>

    <form method="POST" action="{{ route('reports.store') }}">
        @csrf

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title">
        </div>

        <div class="mb-3">
            <label>Message Content</label>
            <textarea name="message_content" rows="8"></textarea>
        </div>

        <div class="mb-3">
            <label>Source Type</label>

            <select name="source_type">
                <option value="sms">SMS</option>
                <option value="email">Email</option>
                <option value="social_media">Social Media</option>
                <option value="website">Website</option>
            </select>
        </div>

        <button type="submit">
            Submit Report
        </button>

    </form>

@endsection
