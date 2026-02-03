@extends('admins.layouts.app')

@section('title', "Resources en attente")

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ressources en attente</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 10px"></th>
                            <th>Nom</th>
                            <th style="width: 150px">Auteur</th>
                            <th style="width: 150px;">Version</th>
                            <th style="width: 100px;">Categorie</th>
                            <th style="width: 100px;">Prix</th>
                            <th style="width: 200px;">Date de publication</th>
                            <th style="width: 125px;">Status</th>
                            <th style="width: 175px; text-align: center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($resources as $resource)
                            <tr>
                                <th>
                                    <a href="{{ route('resources.view', ['resource' => $resource, 'slug' => $resource->slug()]) }}">
                                        <img style="border-radius: 3px" width="40" height="40"
                                             src="{{ $resource->icon->getPath() }}"
                                             alt="Icon de la resource {{ $resource->id }}">
                                    </a>
                                </th>
                                <th>{{ $resource->name }}</th>
                                <th>
                                    <a href="{{ route('admin.users.show', ['user' => $resource->user ]) }}">{{ $resource->user->name }}</a>
                                </th>
                                <th>{{ $resource->version?->version ?? 'N/A' }}</th>
                                <th>{{ $resource->category->name }}</th>
                                <th style="@if(!$resource->price == 0) color: rgb(72, 187, 156); @else color: rgb(0, 0, 0); @endif">{{ $resource->price == 0 ? 'Gratuit' : $resource->price . "€" }}</th>
                                <th>{{ format_date($resource->created_at, true) }}</th>
                                <th style="color: {{ $resource->getStatus()['color'] }}">{{ strtoupper(__($resource->getStatus()['message'])) }}</th>
                                <th>
                                    <div class="d-flex justify-content-around">
                                        <form action="{{ route('admin.resources.accept', ['resource' => $resource]) }}"
                                              method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm rounded-0">Accepter
                                            </button>
                                        </form>
                                        <button data-toggle="modal" data-target="#refuseModal{{ $resource->id }}"
                                                class="btn btn-danger btn-sm rounded-0">Refuser
                                        </button>
                                        <!-- Logout Modal-->
                                        <div class="modal fade " id="refuseModal{{ $resource->id }}" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel"
                                             aria-hidden="true">
                                            <form method="POST"
                                                  action="{{ route('admin.resources.refuse', ['resource' => $resource]) }}">

                                                @csrf

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="exampleModalLabel">Voulez vous vraiment refuser
                                                                cette resource
                                                                ?</h5>
                                                            <button class="close" type="button" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="reason">Écrire la raison du refus</label>
                                                                <textarea id="reason" name="reason"
                                                                          class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary btn-sm rounded-0"
                                                                    type="button"
                                                                    data-dismiss="modal">Annuler
                                                            </button>
                                                            <button type="submit"
                                                                    class="btn btn-danger btn-sm rounded-0">Refuser la
                                                                ressource
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
