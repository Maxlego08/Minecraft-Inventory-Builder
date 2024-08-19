<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Resources</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="width: 10px"></th>
                        <th style="width: 150px">Auteur</th>
                        <th>Nom</th>
                        <th style="width: 125px;">Version</th>
                        <th style="width: 100px;">Prix</th>
                        <th style="width: 130px;">Total des ventes</th>
                        <th style="width: 100px;">Téléchargements</th>
                        <th style="width: 175px;">Date de publication</th>
                        <th style="width: 125px;">Status</th>
                        <th style="width: 100px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($resources as $resource)
                        @include('admins.elements.resources')
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $resources->withQueryString()->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>
