<div class="card rounded-1 mb-3">
    <div class="card-body">
        <div class="members-picture">
            <h2>{{ __('profiles.discord.discord') }}</h2>
            @if(isset(user()->discord))
                <div class="discord-unlink">
                    <form action="{{ route('profile.discord') }}" method="POST">
                        @csrf
                        <button type="submit">
                            {{ __('profiles.discord.remove') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
        @if(!isset(user()->discord))
            <span class="discord-invalid">{!! __('profiles.discord.info') !!}</span>

            <div class="discord">
                <a href="{{ user()->getDiscordAuthLink() }}" class="discord-link">
                    {{ __('profiles.discord.link') }}
                </a>
            </div>
        @elseif(!user()->discord->is_valid)
            <div class="discord-invalid">
                <i class="fas fa-exclamation-triangle"></i> {{ __("Impossible de récupérer les informations de votre compte discord. Si l'erreur persiste merci de contacter l'équipe sur notre discord.") }}
            </div>
        @else
            <div class="discord-profil">
                <div class="discord-profil-avatar">
                    <img src="{{ user()->discord->getAvatar() }}" alt="{{ user()->discord->username }} avatar">
                </div>
                <div class="discord-profil-user">
                    <span
                        class="discord-profil-user-name">{{ user()->discord->username }}#{{ user()->discord->discriminator }}</span>
                    <span class="discord-profil-user-id">{{ user()->discord->discord_id }}</span>
                </div>
            </div>
        @endif
    </div>
</div>
