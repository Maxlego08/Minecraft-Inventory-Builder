<tr>
    <td>{{ $currentFolder->id }}</td>
    <td>
        @include('admins.elements.user', ['currentUser' => $currentFolder->user])
    </td>
    <td>{{ $currentFolder->name }}</td>
    <td>{{ $currentFolder->children->count() }}</td>
    <td>{{ $currentFolder->inventories->count() }}</td>
    <td>
        <a href="{{ route('admin.inventories.folders.user', $currentFolder) }}"><i class="fas fa-edit"></i></a>
    </td>
</tr>
