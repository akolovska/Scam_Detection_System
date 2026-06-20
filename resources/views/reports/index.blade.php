@extends('layout')

@section('content')

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h1 style="margin:0;">Scam Reports</h1>

        @auth
            <a href="{{ route('reports.create') }}" class="btn">
                Create Report
            </a>
        @endauth
    </div>


    <form method="GET" action="{{ route('reports.index') }}"
          style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">

        <select name="source_type">
            <option value="">All sources</option>
            <option value="sms" @selected(request('source_type')=='sms')>SMS</option>
            <option value="email" @selected(request('source_type')=='email')>Email</option>
            <option value="chat" @selected(request('source_type')=='chat')>Chat</option>
            <option value="social_media" @selected(request('source_type')=='social_media')>Social Media</option>
        </select>

        <select name="risk">
            <option value="">All risk levels</option>
            <option value="low" @selected(request('risk')=='low')>Low (0–39)</option>
            <option value="medium" @selected(request('risk')=='medium')>Medium (40–69)</option>
            <option value="high" @selected(request('risk')=='high')>High (70–100)</option>
        </select>

        <button class="btn" type="submit">Filter</button>
    </form>

    <div style="overflow-x:auto;">
        <table>

            <thead>
            <tr>
                <th>Title</th>
                <th>Risk</th>
                <th>Source</th>
                <th>User</th>
                <th style="width:180px;">Actions</th>
            </tr>
            </thead>

            <tbody>

            @forelse($reports as $report)
                <tr>

                    <td>
                        <strong>{{ $report->title }}</strong>
                    </td>

                    <td>
                        {{-- simple risk badge --}}
                        @if($report->risk_score < 40)
                            <span style="color:green;">{{ $report->risk_score }} (Low)</span>
                        @elseif($report->risk_score < 70)
                            <span style="color:orange;">{{ $report->risk_score }} (Medium)</span>
                        @else
                            <span style="color:red;">{{ $report->risk_score }} (High)</span>
                        @endif
                    </td>

                    <td>{{ ucfirst($report->source_type->value) }}</td>

                    <td>{{ $report->user->name ?? 'Unknown' }}</td>

                    <td style="display:flex; gap:10px; align-items:center;">

                        <a class="btn" href="{{ route('reports.show', $report->id) }}">
                            View
                        </a>

                        @auth
                            @if(auth()->user()->role === \App\Enums\UserRole::ADMIN)
                                <form method="POST"
                                      action="{{ route('reports.destroy', $report->id) }}"
                                      onsubmit="return confirm('Delete this report?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>

                                </form>
                            @endif
                        @endauth

                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:20px;">
                        No reports found
                    </td>
                </tr>
            @endforelse

            </tbody>

        </table>
    </div>

@endsection
