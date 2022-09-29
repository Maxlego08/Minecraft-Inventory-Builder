<div class="card rounded-0">
    <div class="card-body">
        <div class="d-flex justify-content-md-between">
            <h2>{{ __('profiles.two_factor.title') }}</h2>
            @if(user()->two_factor_secret)
                <form method="POST" action="{{ url('user/two-factor-authentication') }}">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm rounded-0 d-block w-100 mt-2">
                        {{ __('profiles.two_factor.disable') }}
                    </button>
                </form>
            @endif
        </div>

        @if(!user()->two_factor_secret)
            {{-- Enable 2FA --}}
            <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                @csrf

                <button type="submit" class="btn btn-primary btn-sm rounded-0 d-block w-100 mt-2">
                    {{ __('profiles.two_factor.enable') }}
                </button>
            </form>
        @else
            @if(session('status') == 'two-factor-authentication-enabled' || !user()->two_factor_confirmed_at)
                <div class="mb-4 font-medium text-sm">
                    <form method="POST" action="{{ url('user/confirmed-two-factor-authentication') }}">
                        @csrf

                        <div class="d-flex flex-column align-items-center mt-4 mb-4">
                            <div class="p-3 bg-white rounded-2 mb-2">
                                {!! user()->twoFactorQrCodeSvg() !!}
                            </div>
                            <div class="d-flex flex-column">
                                <span class="text-xl-center h5">{{ __('profiles.two_factor.key.title', ['key' => decrypt(user()->two_factor_secret)]) }}</span>
                                <span>{{ __('profiles.two_factor.key.info') }}</span>
                                <span>{{ __('profiles.two_factor.key.key') }} <span class="bg-light ps-1 pe-1 text-black">{{ decrypt(user()->two_factor_secret) }}</span></span>
                                <span>{{ __('profiles.two_factor.key.account') }} <span class="bg-light ps-1 pe-1 text-black">{{ user()->email }}</span></span>
                                <span>{{ __('profiles.two_factor.key.time') }} <span class="bg-light ps-1 pe-1 text-black">{{ __('messages.yes') }}</span></span>
                            </div>
                        </div>

                        <label for="code" class="form-label">{{ __('profiles.two_factor.label') }}</label>
                        <input type="text" id="code" name="code" class="form-control rounded-0 mb-2">
                        <button type="submit"
                                class="btn btn-primary btn-sm rounded-0 d-block w-100 mt-2">{{ __('profiles.two_factor.confirm') }}</button>
                    </form>
                </div>
            @elseif (session('status') == 'two-factor-authentication-confirmed' || session('status') == 'recovery-codes-generated')
                {{-- Show SVG QR Code, After Enabling 2FA --}}
                <span class="mb-2">{{ __('profiles.two_factor.info') }}</span>

                {{-- Show 2FA Recovery Codes --}}
                <span class="mb-2">{{ __('profiles.two_factor.info2') }}</span>

                <ul>
                    @foreach (json_decode(decrypt(user()->two_factor_recovery_codes), true) as $code)
                        <li>{{ $code }}</li>
                    @endforeach
                </ul>

                <form method="POST" action="{{ route('profile.2fa') }}">
                    @csrf
                    <button type="submit"
                            class="btn btn-success btn-sm rounded-0 d-block mt-2">{{ __('profiles.two_factor.download') }}</button>
                </form>

            @elseif(user()->two_factor_confirmed_at)
                {{-- Regenerate 2FA Recovery Codes --}}
                <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}">
                    @csrf
                    <button type="submit"
                            class="btn btn-primary btn-sm rounded-0 d-block w-100 mt-2">{{ __('profiles.two_factor.regen') }}</button>
                </form>
            @endif
        @endif
    </div>
</div>
