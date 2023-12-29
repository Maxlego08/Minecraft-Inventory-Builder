@extends('admins.layouts.app')

@section('title', $resource->name)

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Détails de la ressource: {{ $resource->name }}</h1>

        <!-- Resource Information -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">Informations:</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 200px">ID</th>
                            <td>{{ $resource->id }}</td>
                        </tr>
                        <tr>
                            <th>Auteur</th>
                            <td>
                                @include('admins.elements.user', ['currentUser' => $resource->user])
                            </td>
                        </tr>
                        <tr>
                            <th>Nom</th>
                            <td>{{ $resource->name }}</td>
                        </tr>
                        <tr>
                            <th>Tag</th>
                            <td>{{ $resource->tag }}</td>
                        </tr>
                        <tr>
                            <th>Version</th>
                            <td>{{ $resource->version->version }}</td>
                        </tr>
                        <tr>
                            <th>Catégorie</th>
                            <td>{{ $resource->category->name }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{!! $resource->toHTML() !!}</td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td style="color: {{ $resource->getStatus()['color'] }}">{{ strtoupper(__($resource->getStatus()['message'])) }}</td>
                        </tr>
                        <tr>
                            <th>Prix</th>
                            <td style="@if(!$resource->price == 0) color: rgb(72, 187, 156); @else color: rgb(0, 0, 0); @endif">{{ $resource->price == 0 ? 'Gratuit' : $resource->price . "€" }}</td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td><img src="{{ $resource->icon->getPath() }}" alt="resource icon"></td>
                        </tr>
                        <tr>
                            <th>Téléchargement</th>
                            <td>{{ $resource->countDownload() }}</td>
                        </tr>
                        @if($resource->price != 0)
                        <tr>
                            <th>Acheteur</th>
                            <td>{{ $resource->buyers->count() }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>{{ $resource->buyers->whereNotNull('payment_id')->count() * $resource->price }}{{ currency($resource->user->paymentInfo?->currency->currency ?: 'eur') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Date de Création</th>
                            <td>{{ format_date($resource->created_at, true) }}</td>
                        </tr>
                        <tr>
                            <th>Date de Mise à Jour</th>
                            <td>{{ format_date($resource->updated_at, true) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Reviews -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">Reviews</h5>
                @foreach ($resource->reviews as $review)
                    <p>{{ $review->user->name }}: {{ $review->score }}</p>
                @endforeach
            </div>
        </div>

        <!-- Versions -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">Versions</h5>
                @foreach ($resource->versions() as $version)
                    <p>{{ $version->version }} - Files: {{ $version->files->count() }}</p>
                @endforeach
            </div>
        </div>

        @if($resource->price != 0)
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title">Acheteurs</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Acheté le</th>
                                <th>Paiement</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($resource->buyers as $buyer)
                                <tr>
                                    <td>
                                        @include('admins.elements.user', ['currentUser' => $buyer->user])
                                    </td>
                                    <td>{{ format_date($buyer->created_at, true) }}</td>
                                    @if($buyer->payment)
                                        <td>
                                            <a href="{{ route('admin.payments.show', $buyer->payment) }}">{{ $buyer->payment->payment_id }}</a>
                                        </td>
                                    @else
                                        <td>Gratuit</td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Accesses, Notifications, and other related data -->
            </div>
    @endif
    </div>
@endsection
