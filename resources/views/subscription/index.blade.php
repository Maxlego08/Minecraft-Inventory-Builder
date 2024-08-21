@extends('layouts.base')

@section('title', __('subscription.title'))

@section('app')

    <div class="content_home pb-5 mt-5 mb-5">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 270"
             fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M0 90.5202L107 97.5434C213 105.347 427 120.173 640 105.347C853 90.5202 1067 45.2601 1280 22.6301C1493 0 1707 0 1813 0H1920V270H1813C1707 270 1493 270 1280 270C1067 270 853 270 640 270C427 270 213 270 107 270H0V90.5202Z"
                  fill="#1A1A2E"/>
        </svg>
        <article class="home_abonnement bg-blue-800 subscription">
            <div class="container">
                <div class="text-center block_title">
                    <h2>{{ __('subscription.title') }}</h2>
                    <div class="d-flex flex-column">
                        <span>{{ __('subscription.description') }}</span>
                        <span>{{ __('subscription.description-2', ['count' => count($resources)]) }}</span>
                    </div>
                </div>
                <div class="subscription-buttons">
                    <div class="title">
                        <span>The longer you stay, the more you save.</span>
                    </div>
                    <div class="buttons">
                        <div class="subscription-buttons-button selected">
                            1 month
                        </div>
                        <div class="subscription-buttons-button">
                            6 months <span class="percent" data-percent="5" data-month="6">5%</span>
                        </div>
                        <div class="subscription-buttons-button">
                            12 months <span class="percent" data-percent="10" data-month="12">10%</span>
                        </div>
                        <div class="subscription-buttons-button">
                            24 months <span class="percent" data-percent="20" data-month="24">20%</span>
                        </div>
                    </div>
                </div>
                <div class="px-2 px-lg-1">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <div class="p-4 rounded-1 bg-blue-700 subscription-card">
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="home_abonnement_price fw-bold fs-2" id="price-value">9.99€</span>
                                    <span>/ month</span>
                                </div>
                                <div class="d-flex justify-content-center align-items-center saving">
                                    Savings: <span id="saving" class="percent ms-1">0.00</span>€
                                </div>
                                <div>
                                    <ul class="nav d-flex flex-column">
                                        @foreach($resources as $resource)
                                            <li class="py-1 d-flex text-green-light">
                                                <i class="bi bi-check-circle me-3"></i>
                                                {!! __('subscription.info.plugin', ['plugin' => $resource->name, 'link' => route('resources.view.id', 1)]) !!}
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="#" class="btn btn-success w-100 rounded-1 mt-4">Subscribe for <span
                                            id="final-price">9.99</span>€</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 270"
             fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M1920 179.48L1813 172.457C1707 164.653 1493 149.827 1280 164.653C1067 179.48 853 224.74 640 247.37C427 270 213 270 107 270L0 270L2.36041e-05 7.62889e-05L107 8.56431e-05C213 9.49099e-05 427 0.000113618 640 0.000132239C853 0.000150861 1067 0.000169569 1280 0.00018819C1493 0.000206811 1707 0.00022552 1813 0.000234786L1920 0.000244141L1920 179.48Z"
                  fill="#1A1A2E"/>
        </svg>
    </div>

@endsection

@push('scripts')
    <script>
        window.addEventListener('load', function () {
            const basePrice = 9.99;
            const priceElement = document.getElementById('price-value');
            const savingElement = document.getElementById('saving');
            const finalPriceElement = document.getElementById('final-price');
            const buttons = document.querySelectorAll('.subscription-buttons-button');

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    buttons.forEach(btn => btn.classList.remove('selected'));

                    this.classList.add('selected');

                    const percentSpan = this.querySelector('.percent');
                    let discount = 0;
                    let month = 1
                    if (percentSpan) {
                        discount = parseInt(percentSpan.getAttribute('data-percent'));
                        month = parseInt(percentSpan.getAttribute('data-month'));
                    }

                    const priceMonth = basePrice * month
                    const finalTotalPrice = priceMonth - (priceMonth * (discount / 100));
                    const finalPrice = finalTotalPrice / month;
                    const finalPriceSaving = priceMonth * (discount / 100);

                    priceElement.textContent = finalPrice.toFixed(2);
                    savingElement.textContent = finalPriceSaving.toFixed(2);
                    finalPriceElement.textContent = finalTotalPrice.toFixed(2);
                });
            });
        });
    </script>
@endpush
