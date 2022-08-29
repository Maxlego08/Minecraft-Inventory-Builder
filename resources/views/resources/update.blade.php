@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="px-3 px-lg-0">
            <div class="container">
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="fw-bold fs-5 mb-0">Faire une mise à jour</h4>
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
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <div class="mb-3">
                                                <label for="name_ressource" class="form-label ms-3">Nom de le
                                                    ressource</label>
                                                <input type="text" class="form-control" id="name_ressource">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="version" class="form-label ms-3">Version</label>
                                                <input type="text" class="form-control" id="version">
                                            </div>
                                        </div>

                                        <div class="my-3">
                                            <div class="mb-2">
                                                <input class="form-check-input" type="radio" name="uplode_file"
                                                       id="uplode_file">
                                                <label class="form-check-label" for="uplode_file">J’upload un
                                                    fichier</label>
                                                <input type="file" class="form-control mt-2">
                                            </div>
                                            <div>
                                                <input class="form-check-input" type="radio" name="link_lien"
                                                       id="link_lien">
                                                <label class="form-check-label" for="link_lien">J’utilise un
                                                    lien</label>
                                                <div class="d-flex mt-2">
                                                    <input type="text" class="form-control">
                                                    <button class="btn btn-secondary rounded-4 ms-4 text-nowrap">ENVOYER
                                                        UN FICHIER
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-3">
                                            <div class="mb-3">
                                                <label for="description_resource" class="form-label ms-3">Description de
                                                    la ressource</label>
                                                <textarea class="form-control" id="description_resource"
                                                          rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <button type="submit"
                                                            class="btn btn-primary rounded-4 d-block w-100 mt-3">
                                                        Enregistrer et mettre à jour
                                                    </button>
                                                </div>
                                                <div class="col-lg-5">
                                                    <a href="{{route('resources.index')}}"
                                                       class="btn btn-danger rounded-4 d-block ms-lg-5 mt-3">Annuler
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
