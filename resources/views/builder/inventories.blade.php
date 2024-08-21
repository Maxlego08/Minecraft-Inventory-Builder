@extends('layouts.base')

@section('app')

    <div class="content_resources_show mb-5">
        <div class="container">

            <div class="px-0 px-lg-0">
                <div class="block_resources_add card my-4 rounded-1">
                    <div class="card-body px-4">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <h1 class="fw-bold fs-3">{{ __('inventories.title') }}</h1>
                                <p>{{ __('inventories.description') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-md-6 col-lg-12">
                                <div class="col-md-6 col-lg-12">
                                    <div class="card mb-3 rounded-1">
                                        <div class="card-body">
                                            <h2 class="text-center fs-5 fw-bold">{{ __('inventories.most.title') }}</h2>
                                            <ul class="list-group">
                                                @foreach($mostInventories as $ms)
                                                    <li class="d-flex mb-2">
                                                        <a class="img_1"
                                                           href="{{ $ms['url'] }}"
                                                           title="{{ $ms['name'] }} profile">
                                                            <img class=""
                                                                 src="{{ $ms['image'] }}"
                                                                 alt="{{ $ms['name'] }}" width="50" height="50">
                                                        </a>
                                                        <div class="ms-3">
                                                            <p class="mb-0 fw-light">{!! $ms['name'] !!}</p>
                                                            <span class="text-muted fs-7">{{ __('inventories.inventory') }}: {{ $ms['count'] }}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @include('resources.elements.sponsor')
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <table class="table table-responsive table-striped table-hover">
                            <thead>
                            <tr>
                                <td>{{ __('inventories.table.user') }}</td>
                                <td>{{ __('inventories.table.file_name') }}</td>
                                <td>{{ __('inventories.table.inventory_name') }}</td>
                                <td>{{ __('inventories.table.size') }}</td>
                                <td>{{ __('inventories.table.action') }}</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inventories as $inventory)
                                @include('builder.elements.inventory', ['inventory' => $inventory])
                            @endforeach
                            </tbody>
                        </table>
                        {!! $inventories->links('elements.pagination') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer-scripts')
    <script>
        function copyTextToClipboard(element, isCommand = false) {
            const tempInput = document.createElement('input');
            tempInput.value = element.getAttribute('data-url');
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            if (isCommand) window.toast('success', '{{ __('inventories.copy_command.title') }}', '{{ __('inventories.copy_command.description') }}', 2000)
            else window.toast('success', '{{ __('inventories.copy.title') }}', '{{ __('inventories.copy.description') }}', 2000)
        }
    </script>
@endpush
