<a href="{{ route('admin.users.show', $currentUser) }}" class="mx-1 text-decoration-none d-flex align-items-center"
   title="Modifier l'utilisateur" data-toggle="tooltip">
    <img style="border-radius: 3px; margin-right: 5px" height="30" width="30"
         src="{{ $currentUser->getProfilePhotoUrlAttribute() }}"
         alt="Image du joueur {{ $currentUser->name }}">
    {!! $currentUser->displayName(false)!!}
</a>
