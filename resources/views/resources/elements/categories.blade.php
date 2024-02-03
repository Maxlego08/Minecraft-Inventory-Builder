<div class="col-md-6 col-lg-12">
    <div class="card mb-3 rounded-1">
        <div class="card-body">
            <h2 class="text-center fs-5 fw-bold">{{ __('resources.name.title') }}</h2>
            <ul class="list-group">
                @foreach($categories as $name => $value)
                    <li class="d-flex justify-content-between align-items-cente">
                        @if($value['sub'])
                            <a class="text-white text-decoration-none" href="#" title="#">{{ $name }}</a><span>{{ $value['count'] }}</span>
                        @else
                            <a class="text-white text-decoration-none ms-2" href="#" title="#">{{ $name }}</a><span>{{ $value['count'] }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
