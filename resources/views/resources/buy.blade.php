@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_buyer py-5 mb-5">
        <div class="container">
            <div class="px-3 px-lg-0">
                <div class="row">
                    <form action="#" method="POST" class="col-lg-7 mb-4">
                        @method('POST')
                        @csrf
                        <div class="card mb-4">
                            <div class="card-body">
                                <h1 class="fs-5 fw-bold mb-3">Vos informations de facturation</h1>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label ms-3">Nom</label>
                                            <input type="text" class="form-control" id="name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label ms-3">Prénom</label>
                                            <input type="text" class="form-control" id="lastname">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="email" class="form-label ms-3">Adresse e-mail</label>
                                            <input type="email" class="form-control" id="email">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h2 class="fs-5 fw-bold mb-3">Moyen de paiement</h2>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="payment_paypal">
                                    <label for="payment_paypal" class="form-check-label ms-3">Nom</label>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h2 class="fs-5 fw-bold mb-3">Confirmation</h2>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="confirmation">
                                    <label class="form-check-label" for="confirmation">
                                        J’accepte les conditions générales du GroupeZ pour cet achat
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mx-auto d-block w-75 mt-2 rounded-4">ACHETER LE PLUGIN</button>
                    </form>
                    <div class="col-lg-5">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h2 class="fs-5 fw-bold mb-3">Contenu du panier</h2>
                                <ul class="list-group list-unstyled mb-5">
                                    <li class="fw-light">1x Plugin de MAINTENANCE V2 | 1.8.x <span
                                            class="fw-bold fs-5 text-primary float-end">1.50€</span></li>
                                </ul>
                                <ul class="list-group list-unstyled mt-5">
                                    <li class="fw-light">SOUS-TOTAL <span class="float-end">1.50€</span></li>
                                    <li class="fw-light">REMISE <span class="float-end">-0.50€</span></li>
                                    <li class="fw-light">TOTAL <span class="float-end">1.00€</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <h2 class="fs-5 fw-bold mb-3">Code de réduction</h2>
                                <form action="" method="POST">
                                    @csrf
                                    @method('POST')
                                    <label for="code_reduc" class="form-label visually-hidden">Code de réduction</label>
                                    <input type="text" class="form-control" id="code_reduc">
                                    <button type="submit" class="btn btn-primary btn-sm w-100 mt-2 rounded-4">APPLIQUER LE CODE</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
