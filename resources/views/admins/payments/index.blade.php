@extends('admins.layouts.app')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Paiements</h1>
        </div>


        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between">
                <form class="form-inline" action="{{ route('admin.payments.index') }}" method="GET">
                    <div class="form-group">
                        <label for="searchInput" class="sr-only">{{ trans('messages.actions.search') }}</label>

                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" name="search"
                                   value="{{ $search ?? '' }}"
                                   placeholder="Rechercher">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <a href="{{route('admin.payments.delete')}}"
                   onclick="return confirm('Voulez vous vraiment supprimer les factures ?')"
                   class="btn btn-danger">Supprimer les facteurs impayés</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col" style="width: 150px">#</th>
                            <th scope="col" style="width: 200px">Utilisateur</th>
                            <th scope="col">Type</th>
                            <th scope="col">Contenu</th>
                            <th scope="col">Payment ID</th>
                            <th scope="col">Status</th>
                            <th scope="col">Crée le</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($payments as $payment)
                            <tr>
                                <th scope="row">{{ $payment->payment_id }}</th>
                                <th>
                                    @include('admins.elements.user', ['currentUser' => $payment->user])
                                </th>
                                <th>{{ $payment->getPaymentTypeName() }}</th>
                                <th>{!! $payment->getPaymentContentNameFormattedLimited() !!}</th>
                                <th>{{ $payment->external_id }}</th>
                                <th style="color: {{ $payment->getColorForStatus() }}">{{$payment->status}}</th>
                                <td>
                                    {{ format_date($payment->created_at) }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="mx-1"
                                       data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                {{ $payments->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
