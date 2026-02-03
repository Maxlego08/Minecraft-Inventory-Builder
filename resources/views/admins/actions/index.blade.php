@php use Illuminate\Support\Str; @endphp
@extends('admins.layouts.app')

@section('title', 'Actions')

@section('content')
    <!-- Begin Page Content -->

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0 text-gray-800">Types d'action</h1>
            <a href="{{ route('admin.actions.create') }}" class="btn btn-sm btn-success">Créer un type d'action</a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Description</th>
                            <th scope="col">Contenu</th>
                            <th scope="col">Addon</th>
                            <th scope="col">zMenu+</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($actions as $action)
                            <tr>
                                <td>{{ $action->id }}</td>
                                <td>{{ $action->name }}</td>
                                <td>{{ Str::limit($action->description, 50) }}</td>
                                <td>{{ count($action->contents) }}</td>
                                <td>{{ $action->addon?->name ?? 'N/A' }}</td>
                                <td>{!! $action->is_zmenu_plus ? '<span class="badge badge-success">Oui</span>' : '<span class="badge badge-secondary">Non</span>' !!}</td>
                                <td>
                                    <a href="{{ route('admin.actions.edit', $action) }}"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $actions->withQueryString()->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
