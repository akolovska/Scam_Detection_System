@extends('layout')

@section('content')

    <h1>Scam Analysis Result</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <h3>{{ $report->title }}</h3>

    <p><strong>Message:</strong> {{ $report->message_content }}</p>

    <hr>

    <p>
        <strong>Risk Score:</strong> {{ $report->risk_score }} / 100
    </p>

    <p>
        <strong>Status:</strong>
        @if($report->risk_score >= 70)
            🔴 High Risk (Scam likely)
        @elseif($report->risk_score >= 40)
            🟠 Medium Risk
        @else
            🟢 Low Risk
        @endif
    </p>

    <p>
        <strong>Category:</strong>
        {{ $report->categories->first()->name ?? 'Unknown' }}
    </p>
    @auth
        @if(auth()->user()->role === \App\Enums\UserRole::ADMIN)
            <form method="POST" action="{{ route('reports.destroy', $report->id) }}">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn-danger">
                    Delete
                </button>
            </form>
        @endif
    @endauth

    <a href="{{ route('reports.index') }}">Back</a>

@endsection
