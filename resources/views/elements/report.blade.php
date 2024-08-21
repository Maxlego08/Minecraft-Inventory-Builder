@auth()
    <!-- Report Modal -->
    <div class="modal fade" id="reportModal{{ $contentId }}" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">{{ __('reports.modal_title', ['content' => $contentTitle]) }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reportForm" action="{{ $contentUrl }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reportReason" class="form-label">{{ __('reports.modal_reason_label') }}</label>
                            <textarea class="form-control rounded-1 mb-1" id="reportReason" name="reason" rows="3" minlength="10" maxlength="2000" required placeholder="{{ __('reports.modal_reason_placeholder') }}"></textarea>
                            <p class="text-danger t-12">{{ __('reports.abuse_warning') }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('reports.modal_close_button') }}</button>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-send"></i> {{ __('reports.modal_submit_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endauth
