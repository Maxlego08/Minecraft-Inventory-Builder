<div>
    <div class="card rounded-1 mb-3">
        <div class="card-body">
            <h1>Newsletter</h1>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (user()->newsletter_active)
                <form action="{{ route('newsletter.inactive') }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-danger">Unsubscribe</button>
                    </div>

                </form>
            @else
                <form action="{{ route('newsletter.active') }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Subscribe</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
