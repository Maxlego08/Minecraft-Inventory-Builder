<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="row">
            <div class="mb-3">
                <label for="name_resource" class="form-label">{{ __('resources.create.title.name') }}</label>
                <input type="text" class="form-control rounded-1 @error('name_resource') is-invalid @enderror"
                       id="name_resource" name="name_resource" maxlength="100" minlength="3" required
                       value="{{ old('name_resource', $resource->name) }}">
                <small>{{ __('resources.create.title.description') }}</small>
                @error('name_resource')
                <div id="name_resource_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tags" class="form-label">{{ __('resources.create.tags.name') }}</label>
                <input type="text" class="form-control rounded-1 @error('tags') is-invalid @enderror" id="tags"
                       name="tags" value="{{ old('tags', $resource->tag) }}"
                       minlength="3" maxlength="150" required>
                <small>{{ __('resources.create.tags.description') }}</small>
                @error('tags')
                <div id="tags_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="required_dependencies" class="form-label">{{ __('resources.create.required_dependencies.name') }}</label>
                <input type="text" class="form-control rounded-1 @error('required_dependencies') is-invalid @enderror" id="required_dependencies"
                       name="required_dependencies" value="{{ old('required_dependencies', $resource->required_dependencies) }}"
                       minlength="3" maxlength="300">
                <small>{{ __('resources.create.required_dependencies.description') }}</small>
                @error('required_dependencies')
                <div id="required_dependencies_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="optional_dependencies" class="form-label">{{ __('resources.create.optional_dependencies.name') }}</label>
                <input type="text" class="form-control rounded-1 @error('optional_dependencies') is-invalid @enderror" id="optional_dependencies"
                       name="optional_dependencies" value="{{ old('optional_dependencies', $resource->optional_dependencies) }}"
                       minlength="3" maxlength="300">
                <small>{{ __('resources.create.optional_dependencies.description') }}</small>
                @error('optional_dependencies')
                <div id="optional_dependencies_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if ($resource->price != 0)
                <hr>

               <div class="mb-3">
                    <label for="price" class="form-label">{{ __('resources.create.price.name') }}</label>
                    <input type="number" step="0.01" min="0.0" max="100.0" placeholder="0.00€ ({{ __('messages.free') }})"
                           class="form-control rounded-1 @error('price') is-invalid @enderror" id="price" name="price"
                           value="{{ old('price', $resource->price) }}">
                    <small>{!! __('resources.create.price.description') !!}</small>
                    @error('price')
                    <div id="price_error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <hr>

            <div class="mb-3">
                <label for="version_base_mc" class="form-label">{{ __('resources.create.native_version.name') }}</label>
                <select class="form-select rounded-1 @error('version_base_mc') is-invalid @enderror"
                        name="version_base_mc" id="version_base_mc" required>
                    @foreach($versions as $v)
                        <option @if(old('version_base_mc', $resource->version_base_mc) === $v->id) selected
                                @endif value="{{ $v->id }}">{{ $v->version }}</option>
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
                                   id="version_mc_{{ $v->id }}" name="versions[]"
                                   @if($resource->containsVersion($v->id)) checked @endif>
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
                       id="contributors" name="contributors" value="{{ old('contributors', $resource->contributors) }}">
                <small>{{ __('resources.create.contributor.description') }}</small>
                @error('version_base_mc')
                <div id="version_base_mc_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="link_source" class="form-label">{{ __('resources.create.code.name') }}</label>
                <input type="url" class="form-control rounded-1 @error('link_source') is-invalid @enderror"
                       id="link_source" name="link_source"
                       value="{{ old('link_source', $resource->source_code_link) }}">
                <small>{{ __('resources.create.code.description') }}</small>
                @error('link_source')
                <div id="link_source_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="link_donation" class="form-label">{{ __('resources.create.donation.name') }}</label>
                <input type="url" class="form-control rounded-1 @error('link_donation') is-invalid @enderror"
                       id="link_donation" name="link_donation"
                       value="{{ old('link_donation', $resource->donation_link) }}">
                <small>{{ __('resources.create.donation.description') }}</small>
                @error('link_donation')
                <div id="link_donation_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="lang_support" class="form-label">{{ __('resources.create.lang.name') }}</label>
                <input type="text" class="form-control rounded-1 @error('lang_support') is-invalid @enderror"
                       id="lang_support" name="lang_support" value="{{ old('lang_support', $resource->lang_support) }}">
                <small>{{ __('resources.create.lang.description') }}</small>
                @error('lang_support')
                <div id="lang_support_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @include('elements.textarea', ['description' => 'Description', 'row' => 30, 'content' => $resource->description])

            <hr>

            <div class="mb-3">
                <label for="link_information" class="form-label">{{ __('resources.create.informations.name') }}</label>
                <input type="url" class="form-control rounded-1 @error('link_information') is-invalid @enderror"
                       id="link_information" name="link_information"
                       value="{{ old('link_information', $resource->link_information) }}">
                <small>{{ __('resources.create.informations.description') }}</small>
                @error('link_information')
                <div id="link_information_error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="link_support" class="form-label">{{ __('resources.create.support.name') }}</label>
                <input type="url" class="form-control rounded-1 @error('link_support') is-invalid @enderror"
                       id="link_support" value="{{ old('link_support', $resource->link_support) }}">
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
                           placeholder="{{ __('resources.create.discord.place') }}"
                           value="{{ old('discord', $resource->discord_server_id) }}">
                    <small>{!! __('resources.create.discord.description') !!}</small>
                    @error('discord')
                    <div id="discord_error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 ms-2">
                    <label for="bstats_id" class="form-label">{{ __('resources.create.bstats.name') }}</label>
                    <input type="text" class="form-control rounded-1 @error('bstats_id') is-invalid @enderror"
                           name="bstats_id" id="bstats_id" maxlength="18" minlength="0"
                           value="{{ old('bstats_id', $resource->bstats_id) }}">
                    <small>{!! __('resources.create.bstats.description') !!}</small>
                    @error('bstats_id')
                    <div id="bstats_id_error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary rounded-1 d-block">{{ __('resources.create.button') }}</button>
        </div>
    </div>
</div>
