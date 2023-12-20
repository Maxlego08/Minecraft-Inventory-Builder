<?php

namespace App\Models\Payment;

use App\Models\Resource\Resource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $user_id
 * @property int $gift_id
 * @property int $type
 * @property float $price
 * @property string $payment_id
 * @property string $external_id
 * @property int $content_id
 * @property string $status
 * @property string $gateway
 * @property User $user
 * @property Carbon $created_at
 * @property Resource $resource
 * @property User\NameColor $nameColor
 * @property Gift $gift
 * @property Currency $currency
 */
class Payment extends Model
{
    use HasFactory;

    const STATUS_PAID = "PAID";
    const STATUS_UNPAID = "UNPAID";
    const STATUS_REFUND = "REFUND";
    const STATUS_DISPUTE = "DISPUTE";
    const STATUS_PENDING = "PENDING";
    const STATUS_CANCEL = "CANCEL";

    public const TYPE_RESOURCE = 0;
    public const TYPE_ACCOUNT_UPGRADE = 1;
    public const TYPE_NAME_COLOR = 2;

    protected $table = "payment_payments";

    protected $fillable = ['id', 'user_id', 'gift_id', 'external_id', 'payment_id', 'content_id', 'currency_id', 'price', 'status', 'type', 'gateway'];

    /**
     * Permet de créer un paiement par défaut
     *
     * @param User $user
     * @param float $price
     * @param int $type
     * @param int $contentId
     * @param int $currencyId
     * @param string $gateway
     * @param null $giftId
     * @return Payment
     */
    public static function makeDefault(User $user, float $price, int $type, int $contentId, int $currencyId, string $gateway, $giftId = null): Payment
    {
        $payment_id = "mib_" . Str::random(10);
        return Payment::create(['payment_id' => $payment_id, 'user_id' => $user->id, 'currency_id' => $currencyId, 'content_id' => $contentId, 'gift_id' => $giftId, 'price' => $price, 'type' => $type, 'status' => self::STATUS_UNPAID, 'gateway' => $gateway]);
    }

    /**
     * Retourne l'utilisateur
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retourne la currency
     *
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * @return BelongsTo
     */
    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'content_id');
    }

    /**
     * @return BelongsTo
     */
    public function nameColor(): BelongsTo
    {
        return $this->belongsTo(User\NameColor::class, 'content_id');
    }

    /**
     * @return BelongsTo
     */
    public function gift(): BelongsTo
    {
        return $this->belongsTo(Gift::class);
    }

    /**
     * Permet de savoir si un paiement est payé
     *
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }


    /**
     * @return bool
     */
    public function isDispute(): bool
    {
        return $this->status === Payment::STATUS_DISPUTE;
    }

    /**
     * Permet de retourner l'état du paiment en Francais
     *
     * @return string
     */
    public function getState(): string
    {
        return match ($this->status) {
            self::STATUS_PAID => "Payé",
            self::STATUS_UNPAID => "Impayé",
            self::STATUS_REFUND => "Remboursé",
            self::STATUS_DISPUTE => "Litige",
            self::STATUS_CANCEL => "Annulé",
            self::STATUS_PENDING => "En attente",
            default => "Impossible de trouver l'état",
        };
    }

    /**
     * Permet de retourner la couleur de l'état du paiement
     *
     * @return string
     */
    public function getStateColor(): string
    {
        return match ($this->status) {
            self::STATUS_PAID => "#1dbf20",
            self::STATUS_UNPAID => "#ca2222",
            self::STATUS_REFUND => "#ca7622",
            self::STATUS_DISPUTE => "#3c0a0a",
            self::STATUS_CANCEL => "#d1201d",
            self::STATUS_PENDING => "#eba134",
            default => "#ffffff",
        };
    }

    public function getEndpoint(): string
    {
        return match ($this->type) {
            self::TYPE_RESOURCE => $this->resource->user->paymentInfo->endpoint_secret,
            default => env('STRIPE_ENDPOINT_SECRET')
        };
    }

    public function updateGiftCode()
    {

        if ($this->gift_id == null) return;

        $this->gift->update(['used' => $this->gift->used + 1]);

        GiftHistory::create(['user_id' => $this->user_id, 'gift_id' => $this->gift_id]);
    }

    public function getPaymentType(): string
    {
        return match ($this->type) {
            Payment::TYPE_RESOURCE => "Minecraft Inventory Builder - Resource {$this->resource->name}.$this->content_id",
            Payment::TYPE_ACCOUNT_UPGRADE => "Minecraft Inventory Builder - Account Upgrade.$this->content_id",
            Payment::TYPE_NAME_COLOR => "Minecraft Inventory Builder - Name color {$this->nameColor->translation()}.{$this->nameColor->id}",
        };
    }

    public function getPaymentDescription(): string
    {
        return match ($this->type) {
            Payment::TYPE_RESOURCE => "Purchase Resource {$this->resource->name}.$this->content_id",
            Payment::TYPE_ACCOUNT_UPGRADE => "Account Upgrade $this->content_id",
            Payment::TYPE_NAME_COLOR => "Name color {$this->nameColor->translation()}.{$this->nameColor->id}",
        };
    }

    public function getPaymentContent(): string
    {
        return match ($this->type) {
            Payment::TYPE_RESOURCE => "Purchase Resource {$this->resource->name}.$this->content_id",
            Payment::TYPE_ACCOUNT_UPGRADE => "Account Upgrade $this->content_id",
            Payment::TYPE_NAME_COLOR => "Name color {$this->nameColor->translation()}.{$this->nameColor->id}",
        };
    }

    public function getPaymentContentName(): string
    {
        return match ($this->type) {
            Payment::TYPE_RESOURCE => $this->resource->name,
            Payment::TYPE_ACCOUNT_UPGRADE => $this->content_id,
            Payment::TYPE_NAME_COLOR => $this->nameColor->translation(),
        };
    }

    public function getPaymentContentNameFormatted(): string
    {
        return match ($this->type) {
            Payment::TYPE_RESOURCE => "<a href='{$this->resource->link('description')}'>{$this->resource->name}</a>",
            Payment::TYPE_ACCOUNT_UPGRADE => $this->content_id,
            Payment::TYPE_NAME_COLOR => "<span class='{$this->nameColor->code}'>{$this->nameColor->translation()}</span>",
        };
    }

    public function getPaymentLogo(): string
    {
        return match ($this->type) {
            Payment::TYPE_RESOURCE => $this->resource->getIconPath(),
            default => 'todo',
        };
    }

}
