@extends('admins.layouts.app')

@section('title', 'Gestion des fichiers')

@php
    function formatBytes(int $bytes, int $precision = 2): string {
        if ($bytes === 0) return '0 o';
        $units = ['o', 'Ko', 'Mo', 'Go', 'To'];
        $factor = floor((strlen((string) $bytes) - 1) / 3);
        $factor = min($factor, count($units) - 1);
        return round($bytes / pow(1024, $factor), $precision) . ' ' . $units[$factor];
    }
@endphp

@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Gestion des fichiers</h1>
        </div>

        {{-- Stats Cards --}}
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total fichiers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalFiles) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file fa-2x text-gray-300"></i>
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
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Espace total (BDD)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formatBytes($totalSizeBytes) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-database fa-2x text-gray-300"></i>
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
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Images</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($imageCount) }} <small class="text-muted">({{ formatBytes($imageSizeBytes) }})</small></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-image fa-2x text-gray-300"></i>
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
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Plugins</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($pluginCount) }} <small class="text-muted">({{ formatBytes($pluginSizeBytes) }})</small></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            {{-- Disk Usage --}}
            <div class="col-xl-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Espace disque</h6>
                    </div>
                    <div class="card-body">
                        @if(isset($diskUsage['server']))
                            @php $server = $diskUsage['server']; @endphp
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="font-weight-bold">{{ $server['label'] }}</span>
                                    <span>{{ formatBytes($server['used']) }} / {{ formatBytes($server['total']) }}</span>
                                </div>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar {{ $server['percent'] > 90 ? 'bg-danger' : ($server['percent'] > 70 ? 'bg-warning' : 'bg-success') }}"
                                         role="progressbar"
                                         style="width: {{ $server['percent'] }}%"
                                         aria-valuenow="{{ $server['percent'] }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $server['percent'] }}%
                                    </div>
                                </div>
                                <small class="text-muted">{{ formatBytes($server['free']) }} disponible</small>
                            </div>
                        @endif

                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Dossier</th>
                                    <th class="text-right">Taille</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($diskUsage as $key => $disk)
                                    @if($key !== 'server')
                                        <tr>
                                            <td>
                                                <i class="fas fa-folder text-warning mr-1"></i>
                                                {{ $disk['label'] }}
                                                @if(isset($disk['count']))
                                                    <span class="text-muted">({{ number_format($disk['count']) }} fichiers)</span>
                                                @endif
                                            </td>
                                            <td class="text-right font-weight-bold">{{ formatBytes($disk['size']) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                        @if(isset($diskUsage['cache']))
                            <div class="mt-3">
                                <form action="{{ route('admin.files.clear-cache') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Vider le cache des thumbnails ?')">
                                        <i class="fas fa-broom mr-1"></i> Vider le cache thumbnails
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Breakdown + Top Users --}}
            <div class="col-xl-6 mb-4">
                <div class="row">
                    {{-- Extension breakdown --}}
                    <div class="col-12 mb-4">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Répartition par type</h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th class="pl-3">Extension</th>
                                            <th class="text-right">Fichiers</th>
                                            <th class="text-right pr-3">Taille</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($extensionStats as $ext)
                                            <tr>
                                                <td class="pl-3">
                                                    <span class="badge badge-{{ in_array($ext->file_extension, \App\Models\File::IMAGE) ? 'info' : 'warning' }}">
                                                        .{{ $ext->file_extension }}
                                                    </span>
                                                </td>
                                                <td class="text-right">{{ number_format($ext->count) }}</td>
                                                <td class="text-right pr-3 font-weight-bold">{{ formatBytes($ext->total_size) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Top users --}}
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Top 10 utilisateurs par espace</h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th class="pl-3">Utilisateur</th>
                                            <th class="text-right">Fichiers</th>
                                            <th class="text-right pr-3">Taille</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($topUsers as $entry)
                                            <tr>
                                                <td class="pl-3">
                                                    @if($entry->user)
                                                        <a href="{{ route('admin.users.show', $entry->user_id) }}">{{ $entry->user->name }}</a>
                                                    @else
                                                        <span class="text-muted">Utilisateur #{{ $entry->user_id }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-right">{{ number_format($entry->file_count) }}</td>
                                                <td class="text-right pr-3 font-weight-bold">{{ formatBytes($entry->total_size) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- File List --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Tous les fichiers</h6>
                <form action="{{ route('admin.files.index') }}" method="GET" class="form-inline">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ $search }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Nom d'origine</th>
                                <th width="70">Ext.</th>
                                <th width="100">Taille</th>
                                <th>Utilisateur</th>
                                <th width="80">Suppr.</th>
                                <th width="140">Date</th>
                                <th width="80">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($files as $file)
                                <tr>
                                    <td>{{ $file->id }}</td>
                                    <td>
                                        <span title="{{ $file->file_name }}">{{ $file->file_upload_name ?: Str::limit($file->file_name, 30) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ in_array($file->file_extension, \App\Models\File::IMAGE) ? 'info' : 'warning' }}">
                                            .{{ $file->file_extension }}
                                        </span>
                                    </td>
                                    <td>{{ formatBytes($file->file_size) }}</td>
                                    <td>
                                        @if($file->user)
                                            <a href="{{ route('admin.users.show', $file->user_id) }}">{{ $file->user->name }}</a>
                                        @else
                                            <span class="text-muted">#{{ $file->user_id }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($file->is_deletable)
                                            <i class="fas fa-check text-success"></i>
                                        @else
                                            <i class="fas fa-lock text-danger"></i>
                                        @endif
                                    </td>
                                    <td>{{ $file->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if(in_array($file->file_extension, \App\Models\File::IMAGE))
                                            <a href="{{ $file->getPath() }}" target="_blank" class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('admin.files.destroy', $file) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce fichier ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Aucun fichier trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($files->hasPages())
                <div class="card-footer">
                    {{ $files->withQueryString()->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>

    </div>

@endsection
