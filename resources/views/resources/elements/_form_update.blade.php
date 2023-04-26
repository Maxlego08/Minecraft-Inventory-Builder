<div class="col-lg-8">
    <div class="mb-3">
        <label for="version_name"
               class="form-label">{{ __('resources.update.version.name') }}</label>
        <input type="text" class="form-control rounded-1" id="version_name"
               name="version_name" value="{{ old('version_name') }}" required placeholder="Version title">
        @error('version_name')
        <div id="version_version_error"
             class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-lg-4">
    <div class="mb-3">
        <label for="version_version"
               class="form-label">{{ __('resources.update.version.version') }}</label>
        <input type="text" class="form-control rounded-1" id="version_version"
               name="version_version" value="{{ old('version_version') }}"
               required placeholder="Currently version: {{ $resource->version->version }}">
        @error('version_version')
        <div id="version_version_error"
             class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="my-3">
    <label class="form-check-label"
           for="upload_file">{{ __('resources.create.file.name') }}</label>
    <input type="file"
           class="form-control rounded-1 mt-2 @error('upload_file') is-invalid @enderror"
           id="upload_file" name="upload_file" required accept=".jar,.zip,.rar">
    <small>{{ __('resources.create.file.description') }}</small>
    @error('upload_file')
    <div id="upload_file_error" class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@include('elements.textarea', ['description' => 'Description', 'row' => 20, 'content' => old('description')])
