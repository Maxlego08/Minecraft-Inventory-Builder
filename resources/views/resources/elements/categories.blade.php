<div class="col-md-6 col-lg-12">
    <div class="card mb-3 rounded-0">
        <div class="card-body">
            <h2 class="text-center fs-5 fw-bold">Catégories</h2>
            <ul class="list-group">
                @foreach($categories as $category => $value)
                    <li class="d-flex justify-content-between align-items-cente">
                        @if($value['sub'])
                            <a class="text-white text-decoration-none" href="#" title="#">{{ $category }}</a><span>{{ $value['count'] }}</span>
                        @else
                            <a class="text-white text-decoration-none ms-2" href="#" title="#">{{ $category }}</a><span>{{ $value['count'] }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
