<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    Suivies par
                </div>
                <div class="col-6">
                    Utilisateurs suivies
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Date de suivie</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($user->followersTable() as $follower)
                                <tr>
                                    <td>@include('admins.elements.user', ['currentUser' => $follower->follower])</td>
                                    <td>{{ format_date($follower->created_at) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Date de suivie</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($user->followings as $follower)
                                <tr>
                                    <td>@include('admins.elements.user', ['currentUser' => $follower])</td>
                                    <td></td>
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
