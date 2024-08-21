@extends('layouts.base')

@section('title', "Payment Success")

@section('app')

    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-center align-items-center flex-column">
            <h2 class="mb-2 text-success">{{ __('payment.success.title') }}</h2>
            <p class="mb-5">{{ __('payment.success.info') }}</p>
            <div class="mb-5">
                <svg viewBox="0 0 100 100" class="animate">
                    <filter id="dropshadow" height="100%">
                        <feGaussianBlur in="SourceAlpha" stdDeviation="3" result="blur"/>
                        <feFlood flood-color="rgb(39, 214, 88)" flood-opacity="0.5" result="color"/>
                        <feComposite in="color" in2="blur" operator="in" result="blur"/>
                        <feMerge>
                            <feMergeNode/>
                            <feMergeNode in="SourceGraphic"/>
                        </feMerge>
                    </filter>

                    <circle cx="50" cy="50" r="46.5" fill="none" stroke="rgba(67, 209, 107, 0.5)" stroke-width="5"/>

                    <path d="M67,93 A46.5,46.5 0,1,0 7,32 L43,67 L88,19" fill="none" stroke="rgba(76, 175, 80, 1)"
                          stroke-width="5" stroke-linecap="round" stroke-dasharray="80 1000" stroke-dashoffset="-220"/>
                </svg>
            </div>
            <div class="col-6">
                <div class="card rounded-1">
                    <div class="card-body">
                        <h3><i class="bi bi-cart"></i> {{ __('payment.order') }}</h3>
                        <hr>
                        <table class="w-100">
                            <thead>
                            <tr>
                                <th class="w-50">{{ __('payment.content') }}</th>
                                <th>{{ __('payment.price') }}</th>
                                <th>{{ __('payment.quantity') }}</th>
                                <th class="text-right">{{ __('payment.total') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="t-12">
                                <td>{!! $name !!}</td>
                                <td>{{ formatPrice($contentPrice, $currency) }}</td>
                                <th>1</th>
                                <td>{{ formatPrice($contentPrice, $currency) }}</td>
                            </tr>
                            <tr class="t-14">
                                <td></td>
                                <td></td>
                                <th>{{ __('payment.subtotal') }}</th>
                                <td>{{ formatPrice($contentPrice, $currency) }}</td>
                            </tr>
                            @if(isset($gift))
                                <tr class="t-14" id="giftTable">
                                    <td class="w-50"></td>
                                    <td></td>
                                    <th>{{ __('payment.gift.title') }}</th>
                                    <td>-{{ formatPrice($giftReduction, $currency) }}
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <hr>
                        <div class="d-flex justify-content-end me-4">
                            <h4>{{ __('payment.total_end') }}</h4>
                            <p class="ms-3 h4 text-info">{{ formatPrice($price, $currency) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
