@if(isset($errors))
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
@endif

<div class="mb-3">
    <label for="url" class="form-label">{{ __('resources.dashboard.discord.url') }}</label>
    <input type="text" class="form-control rounded-1 @error('url') is-invalid @enderror" id="url" minlength="120"
           name="url" value="{{ old('url', $discord->url ?? '') }}" placeholder="https://discord.com/api/webhooks/..."
           required>
    @error('url')
    <div id="password-error" class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-check-label" for="event">{{ __('resources.dashboard.discord.event') }}</label>
    <select class="form-control rounded-1 @error('event') is-invalid @enderror" aria-label=""
            name="event" id="event" required>
        @foreach($events as $event)
            <option value="{{ $event }}"
                    @if(old('event', $discord->event ?? '') === $event) selected @endif>{{ $event }}</option>
        @endforeach
    </select>
    @error('event')
    <div id="event-error" class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="textarea" class="form-check-label">{{ __('resources.dashboard.discord.content') }}</label>
    <textarea id="textarea" name="textarea" class="form-control rounded-1 @error('textarea') is-invalid @enderror"
              placeholder="**{client_name}.{client_id}** has just bought the resource **{payment_content_name}.{payment_content_id}** for {payment_price}{payment_currency}. (Payment ID {payment_id})"
              rows="3">{{ old('textarea', $discord->content ?? '') }}</textarea>
    @error('textarea')
    <div id="textarea-error" class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="username" class="form-label">{{ __('resources.dashboard.discord.username') }}</label>
    <input type="text" class="form-control rounded-1 @error('username') is-invalid @enderror" id="username"
           name="username" value="{{ old('username', $discord->username ?? '') }}"
           placeholder="Minecraft Inventory Builder">
    @error('username')
    <div id="username-error" class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="avatar_url" class="form-label">{{ __('resources.dashboard.discord.avatar_url') }}</label>
    <input type="text" class="form-control rounded-1 @error('avatar_url') is-invalid @enderror" id="avatar_url"
           name="avatar_url" value="{{ old('avatar_url', $discord->avatar_url ?? '') }}"
           placeholder="https://img.groupez.dev/your_image.png">
    @error('avatar_url')
    <div id="avatar_url-error" class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<hr>
<div id="add-embed" class="btn btn-sn btn-primary mb-3"
     style="cursor: pointer">{{ __('resources.dashboard.discord.embed.add') }}</div>
<div id="embeds"
     data-name-color="{{ __('resources.dashboard.discord.embed.color') }}"
     data-name-description="{{ __('resources.dashboard.discord.embed.description') }}"
     data-name-footer="{{ __('resources.dashboard.discord.embed.footer') }}"
     data-name-url="{{ __('resources.dashboard.discord.embed.url') }}"
     data-name-thumbnail="{{ __('resources.dashboard.discord.embed.thumbnail') }}"
     data-name-title="{{ __('resources.dashboard.discord.embed.title') }}"
>

    @if(isset($discord))

        @foreach($discord->embeds as $embed)
            <div>
                <hr>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-check-label"
                               for="title">{{ __('resources.dashboard.discord.embed.title') }}</label>
                        <input type="text" class="form-control rounded-1" id="title" value="{{ $embed->title }}"
                               name="title[]">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-check-label"
                               for="url_embed">{{ __('resources.dashboard.discord.embed.url') }}</label>
                        <input type="text" class="form-control rounded-1" id="url_embed" value="{{ $embed->url }}"
                               name="url_embed[]">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-check-label"
                               for="thumbnail">{{ __('resources.dashboard.discord.embed.thumbnail') }}</label>
                        <input type="text" class="form-control rounded-1" id="thumbnail"
                               value="{{ $embed->thumbnail }}"
                               name="thumbnail[]">
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-check-label"
                                   for="footer">{{ __('resources.dashboard.discord.embed.footer') }}</label>
                            <input type="text" class="form-control rounded-1" id="footer" value="{{ $embed->footer }}"
                                   name="footer[]">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description">{{ __('resources.dashboard.discord.embed.description') }}</label>
                    <textarea id="description" name="description[]"
                              class="form-control rounded-1"
                              rows="3">{{ $embed->description ?? '' }}</textarea>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                            <label for="color"
                                   class="form-check-label">{{ __('resources.dashboard.discord.embed.color') }}</label>
                            <input type="text" class="form-control rounded-1" id="color" name="color[]"
                                   value="{{ $embed->color }}" data-coloris required
                                   title="Choose your color">
                    </div>
                    <div class="col-6 d-flex justify-content-end align-items-end mb-3">
                        <span class="btn btn-sm btn-danger remove-embed"><i class="bi bi-trash me-2"></i>Delete</span>
                    </div>
                </div>
            </div>
        @endforeach

    @endif

</div>
<hr>

