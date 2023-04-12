<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-9">
                <div class="mb-3">
                    <label for="name_resource" class="form-label">{{ __('resources.create.title.name') }}</label>
                    <input type="text" class="form-control rounded-1 @error('name_resource') is-invalid @enderror"
                           id="name_resource" name="name_resource" maxlength="100" minlength="3" required value="{{ old('name_resource') }}">
                    <small>{{ __('resources.create.title.description') }}</small>
                    @error('name_resource')
                    <div id="name_resource_error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-3">
                <div class="mb-3">
                    <label for="version" class="form-label">{{ __('resources.create.version.name') }}</label>
                    <input type="text" class="form-control rounded-1 @error('version') is-invalid @enderror"
                           id="version" name="version" maxlength="10" minlength="1" required value="{{ old('version') }}">
                    <small>{{ __('resources.create.version.description') }}</small>
                    @error('version')
                    <div id="version_error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="tags" class="form-label">{{ __('resources.create.tags.name') }}</label>
                <input type="text" class="form-control rounded-1 @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}"
                       minlength="3" maxlength="150">
                <small>{{ __('resources.create.tags.description') }}</small>
                @error('tags')
                <div id="tags_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>

            <div class="mb-3">
                <label class="form-check-label" for="category">{{ __('resources.create.category.name') }}</label>
                <select class="form-control rounded-1 mt-2 @error('category') is-invalid @enderror" aria-label=""
                        name="category" id="category">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}"
                                @if(old('category') === $c->id) selected @endif>{{ $c->name }}</option>
                    @endforeach
                </select>
                <small>{{ __('resources.create.category.description') }}</small>
                @error('category')
                <div id="category_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-check-label" for="upload_file">{{ __('resources.create.file.name') }}</label>
                <input type="file" class="form-control rounded-1 mt-2 @error('upload_file') is-invalid @enderror"
                       id="upload_file" name="upload_file" required accept=".jar,.zip,.rar">
                <small>{{ __('resources.create.file.description') }}</small>
                @error('upload_file')
                <div id="upload_file_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">{{ __('resources.create.price.name') }}</label>
                <input type="number" step=".01" min="0" max="100" placeholder="0.00€ ({{ __('messages.free') }})"
                       class="form-control rounded-1 @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                @if ($role->premium_resources)
                    <small>{!! __('resources.create.price.description') !!}</small>
                @else
                    <small class="text-danger">{!! __('resources.create.price.permission') !!}</small>
                @endif
                @error('price')
                <div id="price_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>

            <div class="mb-3">
                <label for="version_base_mc" class="form-label">{{ __('resources.create.native_version.name') }}</label>
                <select class="form-select rounded-1 @error('version_base_mc') is-invalid @enderror"
                        name="version_base_mc" id="version_base_mc" required>
                    @foreach($versions as $v)
                        <option @if(old('version_base_mc') === $v->id) selected @endif value="{{ $v->id }}">{{ $v->version }}</option>
                    @endforeach
                </select>
                <small>{{ __('resources.create.native_version.description') }}</small>
                @error('version_base_mc')
                <div id="version_base_mc_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="versions[]" class="form-label">{{ __('resources.create.minecraft_version.name') }}</label>
                <div class="row row-cols-3 row-cols-lg-5 px-3">
                    @foreach($versions as $v)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="{{ $v->id }}"
                                   id="version_mc_{{ $v->id }}" name="versions[]">
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
                <label for="contributors" class="form-label">{{ __('resources.create.contributor.name') }}</label>
                <input type="text" class="form-control rounded-1 @error('contributors') is-invalid @enderror"
                       id="contributors" name="contributors" value="{{ old('contributors') }}">
                <small>{{ __('resources.create.contributor.description') }}</small>
                @error('version_base_mc')
                <div id="version_base_mc_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="link_source" class="form-label">{{ __('resources.create.code.name') }}</label>
                <input type="url" class="form-control rounded-1 @error('link_source') is-invalid @enderror"
                       id="link_source" name="link_source" value="{{ old('link_source') }}">
                <small>{{ __('resources.create.code.description') }}</small>
                @error('link_source')
                <div id="link_source_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="link_donation" class="form-label">{{ __('resources.create.donation.name') }}</label>
                <input type="url" class="form-control rounded-1 @error('link_donation') is-invalid @enderror"
                       id="link_donation" name="link_donation" value="{{ old('link_donation') }}">
                <small>{{ __('resources.create.donation.description') }}</small>
                @error('link_donation')
                <div id="link_donation_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="lang_support" class="form-label">{{ __('resources.create.lang.name') }}</label>
                <input type="text" class="form-control rounded-1 @error('lang_support') is-invalid @enderror"
                       id="lang_support" name="lang_support" value="{{ old('lang_support') }}">
                <small>{{ __('resources.create.lang.description') }}</small>
                @error('lang_support')
                <div id="lang_support_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div id="bbcodePreview"></div>

            @include('elements.textarea', ['description' => 'Description', 'row' => 30])

            <hr>

            <div class="mb-3">
                <label for="link_information" class="form-label">{{ __('resources.create.informations.name') }}</label>
                <input type="url" class="form-control rounded-1 @error('link_information') is-invalid @enderror"
                       id="link_information" name="link_information" value="{{ old('link_information') }}">
                <small>{{ __('resources.create.informations.description') }}</small>
                @error('link_information')
                <div id="link_information_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="link_support" class="form-label">{{ __('resources.create.support.name') }}</label>
                <input type="url" class="form-control rounded-1 @error('link_support') is-invalid @enderror"
                       id="link_support">
                <small>{!! __('resources.create.support.description') !!}</small>
                @error('link_support')
                <div id="link_support_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 d-flex">
                <div class="col-6 me-2">
                    <label for="discord" class="form-label">{{ __('resources.create.discord.name') }}</label>
                    <input type="text" class="form-control rounded-1 @error('discord') is-invalid @enderror"
                           name="discord" id="discord" minlength="18" maxlength="18"
                           placeholder="{{ __('resources.create.discord.place') }}" value="{{ old('discord') }}">
                    <small>{!! __('resources.create.discord.description') !!}</small>
                    @error('discord')
                    <div id="discord_error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 ms-2">
                    <label for="bstats_id" class="form-label">{{ __('resources.create.bstats.name') }}</label>
                    <input type="text" class="form-control rounded-1 @error('link_support') is-invalid @enderror"
                           name="bstats_id" id="bstats_id" maxlength="18" minlength="0">
                    <small>{!! __('resources.create.bstats.description') !!}</small>
                    @error('bstats_id')
                    <div id="bstats_id_error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>

            <div class="mb-4">
                <label class="form-check-label" for="icon">{{ __('resources.create.image.name') }}</label>
                <input type="file" class="form-control rounded-1 mt-2 @error('icon') is-invalid @enderror" name="icon"
                       id="icon" accept=".jpg,.jpeg,.png" required>
                <small>{{ __('resources.create.image.description') }}</small>
                @error('icon')
                <div id="icon_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary rounded-1 d-block">{{ __('resources.create.button') }}</button>
        </div>
    </div>
</div>

@push('footer-scripts')
    @vite(['resources/js/editor/editor.js'])
@endpush
