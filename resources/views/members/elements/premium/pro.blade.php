@php use App\Models\UserRole; @endphp
<div>
    <div class="p-4 rounded-1 bg-blue-700">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="fw-normal">
                <span class='btn-role btn-pro rounded-1'><i class='me-2 {{ UserRole::ICON_PRO }}'></i>Pro</span>
            </h3>
            @auth()
                @if(user()->role->isPremium())
                    <div>
                        <span class="home_abonnement_price fw-bold fs-5 text-danger text-decoration-line-through me-2">49.99€</span><span class="home_abonnement_price fw-bold fs-2">35€</span>
                    </div>
                @else
                    <span class="home_abonnement_price fw-bold fs-2">49.99€</span>
                @endif
            @endauth
            @guest()
                <span class="home_abonnement_price fw-bold fs-2">49.99€</span>
            @endguest
        </div>
        <ul class="nav d-flex flex-column">
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{!! __('upgrade.roles.zmenu+') !!}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.creator_dashboard') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.discord_support_ticket') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.discord_support_forum') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.resource_access') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.resource_amount', ['size' => '1.000']) }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.image_size', ['size' => '50MB']) }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.image_global_size', ['size' => '2GB']) }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.resource_premium') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.resource_gift_code') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.gift_access') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.discord_webhook') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.discord_webhook_amount', ['size' => 20]) }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.banner_change') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.resource_priority') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.inventory_amount', ['size' => '10.000']) }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.inventory_folder', ['size' => '1.000']) }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.resource_fee') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.name_color_reduction') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.gif_avatar') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.auto_response') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.username') }}</li>
        </ul>

        @auth()
            @if(user()->role->isPro())
                <div class="btn btn-secondary w-100 rounded-1 mt-4 disabled">{{ __('upgrade.already') }}</div>
            @else
                <a href="{{ route('premium.checkout', UserRole::PRO) }}"
                   class="btn btn-success w-100 rounded-1 mt-4">{{ __('upgrade.purchase', ['price' => user()->role->isPremium() ? '35' : '49.99']) }}</a>
            @endif
        @endauth
        @guest()
            <a href="{{ route('premium.checkout', UserRole::PRO) }}"
               class="btn btn-success w-100 rounded-1 mt-4">{{ __('upgrade.purchase', ['price' => '49.99']) }}</a>
        @endguest

    </div>
</div>
