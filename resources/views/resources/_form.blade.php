<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-9">
                <div class="mb-3">
                    <label for="name_ressource" class="form-label">{{ __('resources.create.title.name') }}</label>
                    <input type="text" class="form-control rounded-0 @error('name_ressource') is-invalid @enderror"
                           id="name_ressource" maxlength="100" minlength="3" required>
                    <small>{{ __('resources.create.title.description') }}</small>
                    @error('name_ressource')
                    <div id="name_ressource_error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-3">
                <div class="mb-3">
                    <label for="version" class="form-label">{{ __('resources.create.version.name') }}</label>
                    <input type="text" class="form-control rounded-0 @error('version') is-invalid @enderror"
                           id="version" maxlength="10" minlength="1" required>
                    <small>{{ __('resources.create.version.description') }}</small>
                    @error('version')
                    <div id="version_error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="tags" class="form-label">{{ __('resources.create.tags.name') }}</label>
                <input type="text" class="form-control rounded-0 @error('tags') is-invalid @enderror" id="tags" minlength="3" maxlength="150">
                <small>{{ __('resources.create.tags.description') }}</small>
                @error('tags')
                <div id="tags_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-check-label" for="upload_file">{{ __('resources.create.file.name') }}</label>
                <input type="file" class="form-control rounded-0 mt-2 @error('upload_file') is-invalid @enderror" id="upload_file" name="upload_file" required accept=".jar,.zip,.rar">
                <small>{{ __('resources.create.file.description') }}</small>
                @error('upload_file')
                <div id="upload_file_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="version_base_mc" class="form-label">{{ __('resources.create.native_version.name') }}</label>
                <select class="form-select rounded-0 @error('version_base_mc') is-invalid @enderror" name="version_base_mc" id="version_base_mc">
                    <option value="-1" selected></option>
                    @foreach($versions as $v)
                        <option value="{{ $v->id }}">{{ $v->version }}</option>
                    @endforeach
                </select>
                <small>{{ __('resources.create.native_version.description') }}</small>
                @error('version_base_mc')
                <div id="version_base_mc_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="contributeurs" class="form-label">{{ __('resources.create.contributor.name') }}</label>
                <input type="text" class="form-control rounded-0 @error('contributeurs') is-invalid @enderror" id="contributeurs" name="contributeurs">
                <small>{{ __('resources.create.contributor.description') }}</small>
                @error('version_base_mc')
                <div id="version_base_mc_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="versions[]" class="form-label">{{ __('resources.create.minecraft_version.name') }}</label>
                <div class="row row-cols-3 row-cols-lg-5 px-3">
                    @foreach($versions as $v)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="{{ $v->id }}" id="version_mc_{{ $v->id }}" name="versions[]">
                            <label class="form-check-label" for="version_mc_{{ $v->id }}">
                                {{ $v->version }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <small>{{ __('resources.create.minecraft_version.description') }}</small>
                @error('versions')
                <div id="versions_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="link_source" class="form-label">{{ __('resources.create.code.name') }}</label>
                <input type="url" class="form-control rounded-0 @error('link_source') is-invalid @enderror" id="link_source">
                <small>{{ __('resources.create.code.description') }}</small>
                @error('link_source')
                <div id="link_source_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="link_donation" class="form-label">{{ __('resources.create.donation.name') }}</label>
                <input type="url" class="form-control rounded-0 @error('link_donation') is-invalid @enderror" id="link_donation">
                <small>{{ __('resources.create.donation.description') }}</small>
                @error('link_donation')
                <div id="link_donation_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="lang_support" class="form-label">{{ __('resources.create.lang.name') }}</label>
                <input type="text" class="form-control rounded-0 @error('lang_support') is-invalid @enderror" id="lang_support">
                <small>{{ __('resources.create.lang.description') }}</small>
                @error('lang_support')
                <div id="lang_support_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div id="bbcodePreview"></div>

            @include('elements.textarea', ['description' => 'Description', 'row' => 30])

            <div class="mb-3">
                <label for="link_information" class="form-label">{{ __('resources.create.informations.name') }}</label>
                <input type="url" class="form-control rounded-0 @error('link_information') is-invalid @enderror" id="link_information">
                <small>{{ __('resources.create.informations.description') }}</small>
                @error('link_information')
                <div id="link_information_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="link_support" class="form-label">{{ __('resources.create.support.name') }}</label>
                <input type="url" class="form-control rounded-0 @error('link_support') is-invalid @enderror" id="link_support">
                <small>{{ __('resources.create.support.description') }}</small>
                @error('link_support')
                <div id="link_support_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-check-label" for="icon">{{ __('resources.create.image.name') }}</label>
                <input type="file" class="form-control rounded-0 mt-2 @error('icon') is-invalid @enderror" name="icon" id="icon" accept=".jpg,.jpeg,.png">
                <small>{{ __('resources.create.image.description') }}</small>
                @error('icon')
                <div id="icon_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary rounded-0 d-block">Enregistrer et créer la ressource</button>
        </div>
    </div>
</div>

@push('footer-scripts')
    @vite(['resources/js/editor/editor.js'])
@endpush
