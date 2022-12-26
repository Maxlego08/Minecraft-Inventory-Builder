@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="px-3 px-lg-0">
            <div class="container">
                <div class="card rounded-0 mb-3">
                    <div class="card-body">
                        <h1 class="fw-bold fs-5 mb-0">Créer une nouvelle ressource</h1>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh
                            at ante luctus
                            convallis.</p>
                    </div>
                </div>

                <div class="card rounded-0">
                    <div class="card-body">
                        <form action="{{ route('resources.create.store') }}" method="POST">
                            @method('POST')
                            @csrf
                            @include('resources._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
