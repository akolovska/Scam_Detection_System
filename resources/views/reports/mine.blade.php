@extends('layout')

@section('content')

<h1 class="text-xl font-semibold mb-4">My Reports</h1>

@if($reports->isEmpty())
<p>No reports submitted yet.</p>
@else
<div style="display: grid; gap: 12px;">
    @foreach($reports as $report)
    <div style="padding: 15px; border: 1px solid #e5e7eb; border-radius: 8px;">

        <h3 class="font-semibold">{{ $report->title }}</h3>

        <p class="text-sm text-gray-600">
            Risk: {{ $report->risk_score }} / 100
        </p>

        <p>
            Status: {{ $report->status }}
        </p>

        <p>
            Category: {{ $report->category?->name ?? 'N/A' }}
        </p>

        <a href="{{ route('reports.show', $report->id) }}" class="text-blue-500">
            View details
        </a>

    </div>
    @endforeach
</div>
@endif

@endsection
