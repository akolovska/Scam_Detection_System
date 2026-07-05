@extends('layout')

@section('content')

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h1 style="margin:0;" class="text-xl font-semibold">Scam Analysis Result</h1>

        <a href="{{ route('reports.index') }}" class="btn">
            Back
        </a>
    </div>

    <div style="padding:20px; border:1px solid #e5e7eb; border-radius:10px;">

        <h2 style="margin-top:0;" class="text-lg font-semibold">{{ $report->title }}</h2>

        <p style="margin-bottom:10px; margin-top: 10px" class="text-md">
            <strong>Message content:</strong><br>
            {{ $report->message_content }}
        </p>

        <hr style="margin:20px 0; border:0; border-top:1px solid #e5e7eb;">

        <p>
            <strong>Risk Score:</strong>
            <span style="font-size:18px;">
            {{ $report->risk_score }} / 100
                @if($report->risk_score >= 70)
                    <span style="color:#dc2626; font-weight:bold;"> 🔴 High Risk (Scam likely)</span>
                @elseif($report->risk_score >= 40)
                    <span style="color:#f59e0b; font-weight:bold;"> 🟠 Medium Risk</span>
                @else
                    <span style="color:#16a34a; font-weight:bold;"> 🟢 Low Risk</span>
                @endif
        </span>
        </p>

        <p>
            <strong>Category:</strong>
            <span style="background:#f3f4f6; padding:4px 10px; border-radius:6px;">
            {{ $report->category->name ?? 'Unknown' }}
        </span>
        </p>
        <p>
            <strong>Status:</strong>
            {{ $report->status }}
        </p>
        <p>
            <strong>Reviewed by:</strong>
            {{ $report->reviewer?->name ?? 'Not yet reviewed' }}
        </p>
        <p>
            <strong>Date of review:</strong>
            {{ $report->reviewed_at ? $report->reviewed_at->format('Y-m-d H:i') : 'Not yet reviewed' }}
        </p>

    </div>
    @if(auth()->user()->role === \App\Enums\UserRole::ADMIN && $report->status === \App\Enums\ScamReportStatus::PENDING)

        <div style="display:flex; gap:10px; margin-top:20px;">


            <form method="POST" action="{{ route('reports.review', $report) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="approved">
                <button class="btn">Approve</button>
            </form>

            <form method="POST" action="{{ route('reports.review', $report) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="rejected">
                <button class="btn btn-danger">Reject</button>
            </form>

        </div>

    @endif

    @auth
        @if(auth()->user()->role === \App\Enums\UserRole::ADMIN)

            <form method="POST"
                  action="{{ route('reports.destroy', $report->id) }}"
                  style="margin-top:20px;"
                  onsubmit="return confirm('Delete this report?')">

                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">
                    Delete Report
                </button>

            </form>

        @endif
    @endauth

@endsection
