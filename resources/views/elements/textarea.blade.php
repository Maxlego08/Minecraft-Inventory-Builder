<div class="mb-3">
    <div id="bbcodePreview"></div>
</div>
<div class="mb-3">
    @if (isset($description))
        <label for="description" class="form-label">{{ $description }}</label>
    @endif
    <textarea id="description" name="description"
              required rows="{{ $row ?? 15 }}" style="opacity: 0;" maxlength="10000"
              class="form-input mb-2 @error('description') invalid @enderror">{{ old('description', $content ?? '') }}</textarea>
    <div class="mt-3 textarea-images pe-3 ps-3 pb-3">
        <div class="images-element rounded-1" id="images">
            @foreach(user()->images() as $image)
                <div class="p-1">
                    <img src="{{ route('image.preview', $image) }}"
                         onclick="addImage('{{ "$image->file_name.$image->file_extension" }}')" height="50"
                         alt="Image {{ $image->file_name }}">
                </div>
            @endforeach
        </div>
    </div>
    <div class="image-upload-input mt-1">
        <span>{{ __('images.textarea.title') }}</span>
        <input type="file" id="image-upload" name="image-upload" class="form-control rounded-1 mt-2"
               accept="{{ user()->role->getImageAcceptInput() }}" multiple>
        <div class="progress mt-2" id="progress" style="display: none">
            <div class="textarea-bar" style="width: 0;" id="bar">
            </div>
        </div>
    </div>
</div>
</div>

@push('footer-scripts')
    @vite(['resources/js/editor/editor.js'])
@endpush
