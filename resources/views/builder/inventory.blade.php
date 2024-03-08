@extends('layouts.base')

@push('styles')
    @viteReactRefresh
    @vite(['resources/js/builder/inventory.js'])
@endpush

@section('title', 'Inventory Builder')

@section('app')

    <div class="p-4">
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-exclamation-diamond"></i> The Inventory Builder is currently under development. The site is
            on <a href="https://github.com/Maxlego08/Minecraft-Inventory-Builder" target="_blank">Github <i
                    class="bi bi-github"></i></a>, if you want to participate to improve it do not hesitate !
        </div>
    </div>

    <div id="builder">
        <div class="inventory-builder">

        </div>
    </div>
    @include('builder.error')

    <!-- Modal -->
    <div class="modal fade modal-lg" id="monModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Information !</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <p>The inventory editor is currently in development.
                        <br>
                        You may encounter bugs during your use. It will also be missing features.
                    </p>
                    <p class="text-danger">Please report your bugs and ideas here: <a
                            href="https://github.com/Maxlego08/Minecraft-Inventory-Builder/issues" target="_blank">https://github.com/Maxlego08/Minecraft-Inventory-Builder/issues</a>
                    </p>
                        <hr>
                    <p>If you want to help the development of the site do not hesitate, your help will be welcome to improve the site</p>
                    <hr>
                    <div>Discord: <a href="https://discord.groupez.dev/" target="_blank">https://discord.groupez.dev/</a></div>
                    <div>Support the project: <a href="{{ route('premium.index') }}">Upgrade my account</a></div>
                    <div>Changelogs: <a href="https://github.com/Maxlego08/Minecraft-Inventory-Builder/blob/master/changelog.md" target="_blank">Click here</a></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script>
        window.Content = {!! json_encode([
        'inventory' => $inventory,
        'versions' => $versions,
        'buttonTypes' => $buttonTypes,
        'sounds' => $sounds,
        ]) !!};
    </script>
@endpush
