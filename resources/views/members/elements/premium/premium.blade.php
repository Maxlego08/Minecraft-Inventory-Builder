@php use App\Models\UserRole; @endphp
<div>
    <div class="p-4 rounded-1 bg-blue-700">
        <h3 class="fw-normal fs-5 mb-0">
            <span class='btn-role btn-premium rounded-1'><i class='me-2 {{ UserRole::ICON_PREMIUM }}'></i>Premium</span>
        </h3>
        <span class="home_abonnement_price fw-bold fs-2">14.99€</span>
        <ul class="nav">
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{!! __('upgrade.roles.zmenu+') !!}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.creator_dashboard') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.discord_support_ticket') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.discord_support_forum') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.resource_access') }}</li>
            <li class="py-1 d-flex text-warning"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.resource_amount', ['size' => 50]) }}</li>
            <li class="py-1 d-flex text-warning"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.image_size', ['size' => '10mb']) }}</li>
            <li class="py-1 d-flex text-warning"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.image_global_size', ['size' => '500mb']) }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.resource_premium') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.resource_gift_code') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.gift_access') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.discord_webhook') }}</li>
            <li class="py-1 d-flex text-warning"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.discord_webhook_amount', ['size' => 5]) }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.banner_change') }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.resource_priority') }}</li>
            <li class="py-1 d-flex text-warning"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.inventory_amount', ['size' => '1.000']) }}</li>
            <li class="py-1 d-flex text-warning"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.inventory_folder', ['size' => '100']) }}</li>
            <li class="py-1 d-flex text-green-light"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.resource_fee') }}</li>
            <li class="py-1 d-flex text-muted"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.name_color_reduction') }}</li>
            <li class="py-1 d-flex text-muted"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.gif_avatar') }}</li>
            <li class="py-1 d-flex text-muted"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.auto_response') }}</li>
            <li class="py-1 d-flex text-muted"><i class="bi bi-check-circle me-3"></i>{{ __('upgrade.roles.username') }}</li>
        </ul>
        <a href="{{ route('premium.checkout', UserRole::PREMIUM) }}" class="btn btn-success w-100 rounded-1 mt-4">{{ __('upgrade.purchase', ['price' => '14.99']) }}</a>
    </div>
</div>
