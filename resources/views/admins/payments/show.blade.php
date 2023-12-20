@extends('admins.layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Détails du Paiement</h1>
        </div>

        <!-- Payment Information Card-->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Paiement: {{ $payment->id }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 150px">Utilisateur</th>
                            <td>
                                <a href="{{ route('admin.users.show', ['user' => $payment->user]) }}" class="text-decoration-none">
                                    <img style="width: 30px; height: 30px; border-radius: 3px"
                                         src="{{ $payment->user->getProfilePhotoUrlAttribute() }}"
                                         alt="Image de profile de l'utilisateur {{ $payment->user->name }}">
                                </a>
                                {!! $payment->user->displayName(false) !!}
                            </td>
                        </tr>
                        <tr>
                            <th>External ID</th>
                            <td>{{ $payment->external_id }}</td>
                        </tr>
                        <tr>
                            <th>Payment ID</th>
                            <td>{{ $payment->payment_id }}</td>
                        </tr>
                        <tr>
                            <th>Contenu</th>
                            <td>{!! $payment->getPaymentContentNameFormatted() !!}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>{{ $payment->price }}{{ currency($payment->currency->currency) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td class="text-capitalize" style="color: {{ $payment->getColorForStatus() }}">{{ strtolower($payment->status) }}</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>{{ $payment->type }}</td>
                        </tr>
                        <tr>
                            <th>Gateway</th>
                            <td class="text-capitalize">{{ $payment->gateway }}</td>
                        </tr>
                        <tr>
                            <th>Gift ID</th>
                            <td>{{ $payment->gift_id }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
