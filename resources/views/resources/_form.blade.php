<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-9">
                <div class="mb-3">
                    <label for="name_ressource" class="form-label ms-3">Nom de le ressource</label>
                    <input type="text" class="form-control" id="name_ressource">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="mb-3">
                    <label for="version" class="form-label ms-3">Version</label>
                    <input type="text" class="form-control" id="version">
                </div>
            </div>
            <div class="mb-3">
                <label for="tags" class="form-label ms-3">Tags</label>
                <input type="text" class="form-control" id="tags">
            </div>

            <div class="my-4 py-2">
                <div class="mb-2">
                    <input class="form-check-input" type="radio" name="uplode_file" id="uplode_file">
                    <label class="form-check-label" for="uplode_file">J’upload un fichier</label>
                    <input type="file" class="form-control mt-2">
                </div>
                <div>
                    <input class="form-check-input" type="radio" name="link_lien" id="link_lien">
                    <label class="form-check-label" for="link_lien">J’utilise un lien</label>
                    <div class="d-flex mt-2">
                        <input type="text" class="form-control">
                        <button class="btn btn-secondary rounded-4 ms-4 text-nowrap">ENVOYER UN FICHIER</button>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="version_base_mc" class="form-label ms-3">Version de base de Minecraft</label>
                <input type="text" class="form-control" id="version_base_mc">
            </div>

            <div class="mb-3">
                <label for="contributeurs" class="form-label ms-3">Contributeurs</label>
                <input type="text" class="form-control" id="contributeurs">
            </div>
            @php($version = ['1.7.x', '1.8.x', '1.9.x', '1.10.x', '1.11.x', '1.12.x', '1.12.x', '1.13.x', '1.14.x', '1.15.x', '1.16.x', '1.17.x', '1.18.x', '1.19.x'])
            <div class="mb-3">
                <label for="contributeurs" class="form-label ms-3">Version de Minecraft compatible (& testée)</label>
                <div class="row row-cols-3 row-cols-lg-5 px-3">
                    @foreach($version as $v)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="" id="version_mc_{{$v}}">
                            <label class="form-check-label" for="version_mc_{{$v}}">
                                {{$v}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-3">
                <label for="link_source" class="form-label ms-3">Lien vers le code source de la ressource</label>
                <input type="text" class="form-control" id="link_source">
            </div>
            <div class="mb-3">
                <label for="link_donation" class="form-label ms-3">Liens vers la page de donation (Facultatif)</label>
                <input type="text" class="form-control" id="link_donation">
            </div>
            <div class="mb-3">
                <label for="lang_support" class="form-label ms-3">Langues supportées</label>
                <input type="text" class="form-control" id="lang_support">
            </div>

            <div class="my-4 py-2">
                <div class="mb-3">
                    <label for="description_resource" class="form-label ms-3">Description de la ressource</label>
                    <textarea class="form-control" id="description_resource" rows="5"></textarea>
                </div>
                <div class="mb-3">
                    <label for="documentation_resource" class="form-label ms-3">Documentation de la ressource</label>
                    <textarea class="form-control" id="documentation_resource" rows="4"></textarea>
                </div>
            </div>

            <div class="mb-3">
                <label for="link_information" class="form-label ms-3">Lien vers des informations supplémentaires</label>
                <input type="text" class="form-control" id="link_information">
            </div>

            <div class="mb-3">
                <label for="link_support" class="form-label ms-3">Lien vers un support actif</label>
                <input type="text" class="form-control" id="link_support">
            </div>
            <div class="mb-4 mt-5">
                <input class="form-check-input" type="checkbox" name="uplode_file" id="uplode_file">
                <label class="form-check-label" for="uplode_file">Je souhaite ajouter une icône à ma ressource</label>
                <input type="file" class="form-control mt-2">
            </div>
            <div>
                <div class="row">
                    <div class="col-lg-7">
                        <button type="submit" class="btn btn-primary rounded-4 d-block w-100 mt-5">Enregistrer et créer la
                            ressource
                        </button>
                    </div>
                    <div class="col-lg-5">
                        <a href="{{route('resources.index')}}" class="btn btn-danger rounded-4 d-block ms-lg-5 mt-5">Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
