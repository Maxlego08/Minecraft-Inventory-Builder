@extends('resources.layouts.base')

@section('title', "$resource->name | Updates")

@section('resource')
    <div class="card mb-4 rounded-1">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr class="text-muted">
                        <th scope="col" class="fw-light">Avis général</th>
                        <th scope="col" class="fw-light">Téléchargement</th>
                        <th scope="col" class="fw-light">Date de sortie</th>
                        <th scope="col" class="fw-light">Version</th>
                        <th scope="col" class="fw-light"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @for ($d = 0; $d < 6; $d++)
                        <tr>
                            <th scope="row" class="fw-normal">15.356.2</th>
                            <td>17 jui. 2022</td>
                            <td>19</td>
                            <td class="text-nowrap">
                            <span class="text-warning text-nowrap">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <i class="bi bi-star"></i>
                            </span>
                                <span class="ms-2">2</span>
                            </td>
                            <td><a href="#" class="btn btn-primary btn-sm fw-light">TÉLÉCHARGER</a></td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
