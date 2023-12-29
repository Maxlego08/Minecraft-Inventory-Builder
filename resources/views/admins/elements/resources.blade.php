<tr>
    <td>
        <a href="{{ route('resources.view', ['resource' => $resource, 'slug' => $resource->slug()]) }}">
            <img style="border-radius: 3px" width="40" height="40"
                 src="{{ $resource->icon->getPath() }}"
                 alt="Icon de la resource {{ $resource->id }}">
        </a>
    </td>
    <td>
        @include('admins.elements.user', ['currentUser' => $resource->user])
    </td>
    <td>{{ $resource->name }}</td>
    <td>{{ $resource->version->version }}</td>
    <td style="@if(!$resource->price == 0) color: rgb(72, 187, 156); @else color: rgb(0, 0, 0); @endif">{{ $resource->price == 0 ? 'Gratuit' : $resource->price . "€" }}</td>
    <td>ToDo</td>
    <td>{{ $resource->countDownload() }}</td>
    <td>{{ format_date($resource->created_at, false) }}</td>
    <td style="color: {{ $resource->getStatus()['color'] }}">{{ strtoupper(__($resource->getStatus()['message'])) }}</td>
    <td>
        <a href="{{ route('resources.edit.index', $resource) }}" class="resource-button-edit"><i class="fa fa-edit"></i></a>
        <a href="{{ route('admin.resources.edit', $resource) }}" class="resource-button-edit"><i class="fa fa-eye"></i></a>
    </td>
</tr>
