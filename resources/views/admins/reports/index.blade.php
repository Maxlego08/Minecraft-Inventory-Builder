@extends('admins.layouts.app')

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Tout les reports</h1>
        <div class="card shadow mb-4 rounded-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Signalés par</th>
                            <th>Type</th>
                            <th>Raison</th>
                            <th>Status</th>
                            <th>Signalé le</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>
                                    @include('admins.elements.user', ['currentUser' => $report->user])
                                </td>
                                <td>{!! $report->displayName() !!}</td>
                                <td>{{ $report->reason }}</td>
                                <td style="color: {{ $report->resolved_at ? 'green' : 'red' }}">{{ $report->resolved_at ? 'Resolved' : 'Open' }}</td>
                                <td>{{ format_date($report->created_at, true) }}</td>
                                <td>
                                    @if(!$report->resolved_at)
                                        <a href="{{ route('admin.reports.view', $report) }}"><i class="fas fa-edit"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
