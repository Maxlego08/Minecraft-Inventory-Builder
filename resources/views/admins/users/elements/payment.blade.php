<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Informations de paiement</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.payment', ['user' => $user]) }}"
                  method="POST">
                @csrf

                <div class="row">
                    <div class="form-group col-6">
                        <label for="pk_live">Stripe Public Key</label>
                        <input type="text" class="form-control" id="pk_live" name="pk_live"
                               value="{{ $user->paymentInfo->pk_live }}">
                    </div>
                    <div class="form-group col-6">
                        <label for="sk_live">Stripe Secret Key</label>
                        <input type="text" class="form-control" id="sk_live" name="sk_live"
                               value="{{ $user->paymentInfo->sk_live }}">
                    </div>
                </div>
                <div class="row">
                <div class="form-group col-6">
                    <label for="paypal_email">Email Paypal</label>
                    <input type="email" class="form-control" id="paypal_email" name="paypal_email"
                           value="{{ $user->paymentInfo->paypal_email }}">
                </div>

                <div class="form-group col-6">
                    <label for="currency_id">Currency</label>
                    <select class="custom-select" id="currency_id" name="currency_id">
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}"
                                    @if($user->paymentInfo->currency_id == $currency->id) selected @endif>{{ $currency->currency }} {{ currency($currency->currency) }}</option>
                        @endforeach
                    </select>
                </div>
                </div>

                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i>
                    Modifier les informations de paiement
                </button>
            </form>
        </div>
    </div>
</div>
