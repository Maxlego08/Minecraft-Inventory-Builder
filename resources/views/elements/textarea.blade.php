<div class="mb-3">
    @if (isset($description))
        <label for="description" class="form-label">{{ $description }}</label>
    @endif
    <textarea id="description" name="description"
              required rows="{{ $row ?? 15 }}" style="opacity: 0;" maxlength="10000"
              class="form-input mb-2 @error('description') invalid @enderror">{{ old('description') }}</textarea>
    <div class="mt-3 textarea-images pe-3 ps-3 pb-3">

        <div class="image-upload-input">
            <span>{{ __('images.textarea.title') }}</span>
            <input type="file" id="image-upload" name="image-upload" class="form-control rounded-0 mt-2"
                   accept=".jpg,.jpeg,.png">
            <div class="progress" id="progress" style="display: none">
                <div class="bar" style="width: 0;" id="bar">
                </div>
            </div>
        </div>
    </div>
</div>
