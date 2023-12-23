@if($user->discord)
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1 class="h3 mb-2 text-gray-800">Discord</h1>
            <div class="discord-unlink">
                <form action="{{ route('admin.users.delete.discord', $user) }}" method="POST">
                    @csrf
                    <button type="submit">Supprimer le discord</button>
                </form>
            </div>
        </div>

        <div class="card shadow mb-4 discord">
            <div class="card-body">

                <div class="discord-profil">
                    <div class="discord-profil-avatar">
                        <img src="{{ $user->discord->getAvatar() }}" alt="{{ $user->discord->username }} avatar">
                    </div>
                    <div class="discord-profil-user">
                    <span
                        class="discord-profil-user-name">{{ $user->discord->username }}#{{ $user->discord->discriminator }}</span>
                        <span class="discord-profil-user-id">{{ $user->discord->discord_id }}</span>
                        <span class="mt-2">Compte relié le {{ format_date($user->discord->created_at, true) }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endif
