@extends('admins.layouts.app')

@section('title', "Conversations")

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Conversations</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                <form class="form-inline" action="{{ route('admin.conversations.index') }}" method="GET">
                    <div class="form-group mb-2">
                        <label for="searchInput" class="sr-only">Recherche</label>

                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" name="search"
                                   value="{{ $search ?? '' }}"
                                   placeholder="Rechercher">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 150px">Crée par</th>
                            <th style="width: 300px">Avec</th>
                            <th style="width: 100px">Messages</th>
                            <th>Titre</th>
                            <th>Crée le</th>
                            <th>Dernier message le</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($conversations as $conversation)
                            <tr>
                                <td>
                                    @include('admins.elements.user', ['currentUser' => $conversation->user])
                                </td>
                                <td class="row">
                                    @foreach($conversation->participants as $participant)
                                        @if($participant->user_id != $conversation->user_id)
                                            @include('admins.elements.user', ['currentUser' => $participant->user])
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $conversation->messages->count() }}</td>
                                <td>{{ $conversation->subject }}</td>
                                <td>{{ format_date($conversation->created_at, true) }}</td>
                                <td>
                                    <a href="{{ $conversation->getLastMessageURL() }}" target="_blank">
                                        {{ format_date($conversation->getLastMessage()->created_at, true) }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('profile.conversations.show', $conversation) }}"
                                       style="margin-right: 5px"
                                       target="_blank">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if(user()->role->isAdmin())
                                        <form action="{{ route('admin.conversations.delete', $conversation) }}"
                                              method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit"
                                                    style="background: none; border: none; padding: 0; cursor: pointer;">
                                                <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $conversations->links('vendor.pagination.bootstrap-4') !!}
            </div>
        </div>
    </div>

@endsection
