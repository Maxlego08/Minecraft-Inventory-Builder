@auth()
    @if(user()->countAccess() > 0 || user()->countResources() > 0)
        <div class="col-md-6 col-lg-12 mb-3">
            @if(user()->countAccess() > 0)
                <a href="{{ route('resources.purchased') }}" class="btn btn-warning w-100 rounded-1 mb-2">{{ __('resources.actions.purchase') }}</a>
            @endif
            @if(user()->countResources() > 0)
                <a href="{{ route('resources.dashboard.resources') }}" class="btn btn-success w-100 rounded-1 mb-2">{{ __('resources.actions.resources') }}</a>
                <a href="{{ route('resources.dashboard.index') }}"
                   class="btn btn-danger w-100 rounded-1 mb-2">{{ __('resources.actions.creator_board') }}</a>
            @endif
        </div>
    @endif
@endauth
