<tr>
    <th>
        <a href="{{ route('resources.view', ['resource' => $resource, 'slug' => $resource->slug()]) }}">
            <img style="border-radius: 3px" width="40" height="40"
                 src="{{ $resource->icon->getPath() }}"
                 alt="Icon de la resource {{ $resource->id }}">
        </a>
    </th>
    <th>
        @include('admins.elements.user', ['currentUser' => $resource->user])
    </th>
    <th>{{ $resource->name }}</th>
    <th>{{ $resource->version->version }}</th>
    <th style="@if(!$resource->price == 0) color: rgb(72, 187, 156); @else color: rgb(0, 0, 0); @endif">{{ $resource->price == 0 ? 'Gratuit' : $resource->price . "€" }}</th>
    <th>ToDo</th>
    <th>{{ $resource->countDownload() }}</th>
    <th>{{ format_date($resource->created_at, false) }}</th>
    <th style="color: {{ $resource->getStatus()['color'] }}">{{ strtoupper(__($resource->getStatus()['message'])) }}</th>
    <th>
        <a href="{{ route('admin.resources.edit', $resource) }}"
           class="resource-button-edit"><i class="fa fa-edit"></i></a>
    </th>
</tr>
