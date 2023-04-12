<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('resources.rate') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('resources.review.store', ['resource' => $resource]) }}">
                <div class="modal-body">
                    @include('elements.stars-static')
                    <input type="hidden" class="form-control rounded-0" id="rate" name="rate">
                    @csrf
                    <div class="mb-3">
                        <label for="message" class="col-form-label">{{ __('messages.message') }}:</label>
                        <textarea class="form-control rounded-0" style="resize: none;" rows="5"
                                  id="message" name="message"></textarea>
                        @error('message')
                        <div id="message_error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small>{{ __('resources.reviews.info') }}</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0 d-block"
                            data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                    <button type="submit" id="rate-submit"
                            class="btn btn-primary rounded-0 d-block disabled">{{ __('resources.review-send') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
