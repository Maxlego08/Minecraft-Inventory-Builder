@extends('layouts.base')

@push('styles')
    @viteReactRefresh
    @vite(['resources/js/builder/inventory.js'])
@endpush

@section('title', 'Inventory Builder')

@section('app')
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
                    <h5 class="modal-title" id="modalLabel">Website Update!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">

                    <h6><strong>What's new?</strong></h6>
                    <ul>
                        <li>Minecraft <strong>1.21.1</strong> is now available in the builder</li>
                        <li>New actions are available for your inventories</li>
                        <li>New heads have been added</li>
                        <li>Several bugs have been fixed</li>
                    </ul>

                    <hr>

                    <h6><strong>Partner - Minestrator</strong></h6>
                    <p>Minestrator is our official partner for Minecraft server hosting. Reliable, performant, and affordable hosting for your servers.</p>
                    <p>Use the code <strong>GROUPEZ</strong> to get <strong>10% off</strong> on your order!</p>
                    <a href="https://minestrator.com/a/GROUPEZ" target="_blank">https://minestrator.com</a>

                    <hr>

                    <h6><strong>Discover zTextGenerator</strong></h6>
                    <p>A new plugin to easily generate text in your inventories. Check it out on Spigot:</p>
                    <a href="https://www.spigotmc.org/resources/ztextgenerator.130697/" target="_blank">https://www.spigotmc.org/resources/ztextgenerator.130697/</a>

                    <hr>

                    <div>Discord: <a href="https://discord.groupez.dev/" target="_blank">https://discord.groupez.dev/</a></div>
                    <div>Support the project: <a href="{{ route('premium.index') }}">Upgrade my account</a></div>
                    <div>Report bugs: <a href="https://github.com/Maxlego08/Minecraft-Inventory-Builder/issues" target="_blank">GitHub Issues</a></div>
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
        'actions' => $actions,
        ]) !!};
    </script>
@endpush
