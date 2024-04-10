<tr>
    <td>
        <a class="text-decoration-none"
           href="{{ $inventory->user->authorPage() }}"
           title="{{ $inventory->user->name }} profile">
            <img src="{{ $inventory->user->getProfilePhotoUrlAttribute() }}"
                 alt="{{ $inventory->user->name }} Avatar" width="30" height="30">
        </a>
        <a class="text-danger text-decoration-none"
           href="{{ $inventory->user->authorPage() }}">{!! $inventory->user->displayName() !!}</a>
    </td>
    <td>
        {{ $inventory->file_name }}
    </td>
    <td>
        {!! \Stevebauman\Purify\Facades\Purify::clean(\Illuminate\Support\Str::limit($inventory->name ?? 'Inventory', 25)) !!}
    </td>
    <td>
        {{ $inventory->size }}
    </td>
    <td>
        <div class="d-flex justify-content-evenly">
            <a target="_blank" title="{{ __('inventories.download') }}"
               href="{{ route('inventory.download', $inventory) }}"><i class="bi bi-cloud-download"></i></a>
            <div class="cursor-pointer" title="{{ __('inventories.copy.info') }}" onclick="copyTextToClipboard(this)" data-url="{{ route('inventory.download', $inventory) }}">
                <i class="bi bi-copy"></i>
            </div>
            <div class="cursor-pointer" title="{{ __('inventories.copy_command.info') }}" onclick="copyTextToClipboard(this, true)" data-url="/zmenu download {{ route('inventory.download', $inventory) }}">
                <i class="bi bi-terminal"></i>
            </div>
        </div>
    </td>
</tr>
