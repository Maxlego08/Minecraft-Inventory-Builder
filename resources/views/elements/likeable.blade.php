@auth()
<div class="d-flex flex-column">
    <div class="footer-section mb-1">
        <div class="footer-section-report">
            <span id="report" class="text-warning cursor-pointer"><i class="bi bi-exclamation-triangle"></i> {{ __('messages.report') }}</span>
        </div>
        <div class="footer-section-like">
            @if(user()->canLike($likeable))
                @if(user()->hasLiked($likeable))
                    <span id="like" class="like-button text-warning cursor-pointer" style="display: none"><i
                            class="bi bi-hand-thumbs-up"></i> {{ __('messages.like') }}</span>
                    <span id="unlike" class="like-button text-warning cursor-pointer"><i
                            class="bi bi-hand-thumbs-down"></i> {{ __('messages.unlike') }}</span>
                @else
                    <span id="like" class="like-button text-warning cursor-pointer"><i
                            class="bi bi-hand-thumbs-up"></i> {{ __('messages.like') }}</span>
                    <span id="unlike" class="like-button text-warning cursor-pointer" style="display: none"><i
                            class="bi bi-hand-thumbs-down"></i> {{ __('messages.unlike') }}</span>
                @endif
            @endif
        </div>
    </div>
    <div id="likes" class="likes" data-url="{{ $url }}" data-token="{{ csrf_token() }}">
        {!! formatLikedBy($likeable) !!}
    </div>
</div>
@endauth
