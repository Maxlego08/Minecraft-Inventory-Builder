{{-- Utilisez l'héritage de layout de SB Admin 2 ici --}}
@extends('admins.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Résoudre le report #{{ $report->id }}</h1>

        <div class="card shadow mb-4 rounded-0">
            <div class="card-header">
                Report Details
            </div>
            <div class="card-body">
                <p><strong>Type:</strong> {!! $report->displayName() !!}</p>
                <p class="d-flex align-items-center"><strong style="padding-right: 5px">Signalé par:</strong> @include('admins.elements.user', ['currentUser' => $report->user])</p>
                <p><strong>Raison:</strong> {{ $report->reason }}</p>
                <p><strong>Signalé le:</strong> {{ $report->created_at->toFormattedDateString() }}</p>
                {{-- Autres détails si nécessaire --}}
            </div>
        </div>

        <div class="card shadow mb-4 rounded-0">
            <div class="card-body">
                <form action="{{ route('admin.reports.resolve', $report) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="resolution_message" class="form-label">Message de résolution</label>
                        <textarea class="form-control rounded-0" id="resolution_message" name="resolution_message" rows="3"
                                  required></textarea>
                        <small>Une notification sera envoyé au joueur qui a signalé le contenu avec le message de résolution.</small>
                    </div>
                    <button type="submit" class="btn btn-success rounded-0">Résoudre le report</button>
                </form>
            </div>
        </div>
    </div>
@endsection
