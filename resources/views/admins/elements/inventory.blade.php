<tr>
    <td>{{ $currentInventory->id }}</td>
    <td>
        @include('admins.elements.user', ['currentUser' => $currentInventory->user])
    </td>
    <td>{{ \Illuminate\Support\Str::limit($currentInventory->folder->name, 20) }}</td>
    <td>{{ \Illuminate\Support\Str::limit($currentInventory->file_name, 20) }}</td>
    <td>{{ \Illuminate\Support\Str::limit($currentInventory->name ?? 'Inventory', 20) }}</td>
    <td>{{ $currentInventory->size }}</td>
    <td>{{ $currentInventory->buttons->count() }}</td>
    <td>{{ format_date($currentInventory->created_at, true) }}</td>
    <td>{{ format_date($currentInventory->updated_at, true) }}</td>
    <td>
        <a href="{{ route('builder.edit', $currentInventory) }}" target="_blank"><i
                class="fas fa-edit"></i></a>
    </td>
</tr>
