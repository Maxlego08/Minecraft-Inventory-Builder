@extends('admins.layouts.app')

@section('title', 'Gestion des Têtes')

@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Gestion des Têtes</h1>
        </div>

        {{-- Stats Cards --}}
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Têtes</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalHeads) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-skull fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sans catégorie</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($uncategorizedHeads) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-question-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Avec catégorie</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($categorizedHeads) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Fichiers JSON locaux</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jsonFilesCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-code fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            {{-- Download Categories --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Télécharger les catégories</h6>
                    </div>
                    <div class="card-body">
                        <p>Télécharge les fichiers JSON depuis l'API minecraft-heads.com pour chaque catégorie (10 catégories).</p>
                        @if($lastDownload)
                            <p class="text-muted mb-3">Dernier téléchargement : <strong>{{ $lastDownload }}</strong></p>
                        @else
                            <p class="text-muted mb-3">Aucun téléchargement effectué.</p>
                        @endif
                        @if($jsonFilesCount > 0)
                            <p class="text-muted mb-3">Catégories présentes : {{ implode(', ', $jsonFiles) }}</p>
                        @endif
                        <form action="{{ route('admin.heads.download') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-download mr-1"></i> Télécharger les catégories
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Categorize Heads --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Catégoriser les têtes</h6>
                    </div>
                    <div class="card-body">
                        <p>Parcourt les têtes sans catégorie et cherche des correspondances dans les fichiers JSON locaux.</p>
                        <p class="text-muted mb-3">Têtes sans catégorie : <strong>{{ number_format($uncategorizedHeads) }}</strong></p>
                        @if($jsonFilesCount === 0)
                            <div class="alert alert-warning mb-3">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Aucun fichier JSON local. Téléchargez d'abord les catégories.
                            </div>
                        @endif
                        <form action="{{ route('admin.heads.categorize') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success" @if($jsonFilesCount === 0) disabled @endif>
                                <i class="fas fa-tags mr-1"></i> Catégoriser les têtes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        {{-- Scrape Heads --}}
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Scraper de nouvelles têtes</h6>
                    </div>
                    <div class="card-body">
                        <p>Lance le scraping de nouvelles têtes depuis minecraft-heads.com pour une plage d'IDs donnée. Les nouvelles têtes seront créées sans catégorie.</p>
                        <form action="{{ route('admin.heads.scrape') }}" method="POST" class="form-inline">
                            @csrf
                            <div class="form-group mr-3 mb-2">
                                <label for="from" class="mr-2">De :</label>
                                <input type="number" class="form-control @error('from') is-invalid @enderror" id="from" name="from" min="1" value="{{ old('from') }}" required>
                                @error('from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mr-3 mb-2">
                                <label for="to" class="mr-2">À :</label>
                                <input type="number" class="form-control @error('to') is-invalid @enderror" id="to" name="to" min="1" value="{{ old('to') }}" required>
                                @error('to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-warning mb-2">
                                <i class="fas fa-spider mr-1"></i> Lancer le scraping
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
