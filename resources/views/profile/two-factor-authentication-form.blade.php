<div class="card rounded-0">
    <div class="card-body">
        <div class="d-flex justify-content-md-between">
            <h2>{{ __('profiles.two_factor.title') }}</h2>
            @if(auth()->user()->two_factor_secret)
                <form method="POST" action="{{ url('user/two-factor-authentication') }}">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm rounded-0 d-block w-100 mt-2">
                        {{ __('profiles.two_factor.disable') }}
                    </button>
                </form>
            @endif
        </div>

        @if(!auth()->user()->two_factor_secret)
            {{-- Enable 2FA --}}
            <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                @csrf

                <button type="submit" class="btn btn-primary btn-sm rounded-0 d-block w-100 mt-2">
                    {{ __('profiles.two_factor.enable') }}
                </button>
            </form>
        @else
            @if(session('status') == 'two-factor-authentication-enabled')
                <div class="mb-4 font-medium text-sm">
                    <form method="POST" action="{{ url('user/confirmed-two-factor-authentication') }}">
                        @csrf

                        <div class="d-flex justify-content-center mt-4 mb-4">
                            <div class="p-3 bg-white rounded-2">
                                {!! auth()->user()->twoFactorQrCodeSvg() !!}
                            </div>
                        </div>

                        <label for="code" class="form-label">{{ __('profiles.two_factor.label') }}</label>
                        <input type="text" id="code" name="code" class="form-control rounded-0 mb-2">
                        <button type="submit"
                                class="btn btn-primary btn-sm rounded-0 d-block w-100 mt-2">{{ __('profiles.two_factor.confirm') }}</button>
                    </form>
                </div>
            @elseif (session('status') == 'two-factor-authentication-confirmed')
                {{-- Show SVG QR Code, After Enabling 2FA --}}
                <span class="mb-2">{{ __('profiles.two_factor.info') }}</span>

                {{-- Show 2FA Recovery Codes --}}
                <span class="mb-2">{{ __('profiles.two_factor.info2') }}</span>

                <div>
                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @elseif(auth()->user()->two_factor_confirm_at)
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
