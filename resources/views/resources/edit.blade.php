@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="px-3 px-lg-0">
            <div class="container">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="fw-bold fs-5 mb-0">Éditer votre ressource</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh
                            at ante luctus
                            convallis.</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="#" method="POST">
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
