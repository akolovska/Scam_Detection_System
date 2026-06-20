@extends('layout')

@section('content')
    <h1 style="margin-bottom:25px;">📊 Scam Detection Statistics</h1>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:30px;">

        <div
            style="background:#fff;border-left:5px solid #2563eb;padding:20px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.05);">
            <h3>Total Reports</h3>
            <h1>{{ $total }}</h1>
        </div>

        <div
            style="background:#fff;border-left:5px solid #16a34a;padding:20px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.05);">
            <h3>Low Risk</h3>
            <h1>{{ $low }}</h1>
        </div>

        <div
            style="background:#fff;border-left:5px solid #f59e0b;padding:20px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.05);">
            <h3>Medium Risk</h3>
            <h1>{{ $medium }}</h1>
        </div>

        <div
            style="background:#fff;border-left:5px solid #dc2626;padding:20px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.05);">
            <h3>High Risk</h3>
            <h1>{{ $high }}</h1>
        </div>

    </div>

    <div
        style="background:white;padding:20px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.05);margin-bottom:25px;">
        <h2>Most Common Category</h2>

        @if($topCategory)
            <p style="font-size:20px;font-weight:bold;">
                {{ $topCategory->name }}
            </p>
            <p>
                {{ $topCategory->reports_count }} reports
            </p>
        @else
            <p>No reports available.</p>
        @endif
    </div>

    <div style="background:white;padding:20px;border-radius:10px;margin-top:20px;">
        <h2>Risk Distribution</h2>
        <canvas id="riskChart"></canvas>

        <h2 style="margin-top:40px;">Category Distribution</h2>
        <canvas id="categoryChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        new Chart(document.getElementById('riskChart'), {
            type: 'pie',
            data: {
                labels: ['Low Risk', 'Medium Risk', 'High Risk'],
                datasets: [{
                    data: [{{ $low }}, {{ $medium }}, {{ $high }}],
                    backgroundColor: [
                        '#22c55e',
                        '#f59e0b',
                        '#ef4444'
                    ]
                }]
            }
        });
    </script>

@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
