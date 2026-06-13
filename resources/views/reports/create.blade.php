@extends('layout')

@section('content')

    <div style="margin-bottom:20px;">
        <h1 style="margin:0;">Submit Scam Report</h1>
        <p style="color:#6b7280; margin-top:5px;">
            Paste a suspicious message and we’ll analyze it.
        </p>
    </div>

    <form method="POST" action="{{ route('reports.store') }}"
          style="max-width:700px; background:white; padding:20px; border-radius:10px; border:1px solid #e5e7eb;">

        @csrf

        <div>
            <label>Title</label>
            <input type="text" name="title" placeholder="e.g. Suspicious bank SMS">
        </div>

        <div>
            <label>Message Content</label>
            <textarea name="message_content" rows="8"
                      placeholder="Paste the full message here..."></textarea>
        </div>

        <div>
            <label>Source Type</label>
            <select name="source_type">
                <option value="sms">SMS</option>
                <option value="email">Email</option>
                <option value="social_media">Social Media</option>
                <option value="website">Website</option>
            </select>
        </div>

        <button type="submit" class="btn" style="width:100%; margin-top:10px;">
            Analyze Report
        </button>

    </form>

@endsection
