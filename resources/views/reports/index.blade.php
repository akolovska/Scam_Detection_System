@extends('layout')

@section('content')

    <h1>Scam Reports</h1>

    @auth
        @if(auth()->user()->role === \App\Enums\UserRole::ADMIN)
            <a href="{{ route('reports.create') }}">Create Report</a>
        @endif
    @endauth

    <form method="GET" action="{{ route('reports.index') }}">

        <select name="source_type">
            <option value="">All sources</option>
            <option value="sms" @selected(request('source_type')=='sms')>SMS</option>
            <option value="email" @selected(request('source_type')=='email')>Email</option>
            <option value="chat" @selected(request('source_type')=='chat')>Chat</option>
            <option value="social_media" @selected(request('source_type')=='social_media')>Social Media</option>
        </select>

        <select name="risk">
            <option value="">All risk levels</option>

            <option value="low" @selected(request('risk')=='low')>
                Low (0–39)
            </option>

            <option value="medium" @selected(request('risk')=='medium')>
                Medium (40–69)
            </option>

            <option value="high" @selected(request('risk')=='high')>
                High (70–100)
            </option>
        </select>

        <button type="submit">Filter</button>
    </form>

    <br><br>

    <table>

        <thead>
        <tr>
            <th>Title</th>
            <th>Risk Score</th>
            <th>Source</th>
            <th>User</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>

        @foreach($reports as $report)

            <tr>

                <td>{{ $report->title }}</td>

                <td>{{ $report->risk_score }}</td>

                <td>{{ $report->source_type }}</td>

                <td>{{ $report->user->name }}</td>

                <td>
                    <a href="{{ route('reports.show', $report->id) }}">
                        View
                    </a>
                </td>
                <td>
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
                </td>


            </tr>

        @endforeach

        </tbody>

    </table>

@endsection
