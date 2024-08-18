<?php

namespace App\Models\User;

use App\Models\Payment\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property int $currency_id
 * @property string $pk_live
 * @property string $sk_live
 * @property string $endpoint_secret
 * @property string $paypal_email
 * @property Currency $currency
 */
class UserPaymentInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'user_id',
        'pk_live',
        'sk_live',
        'endpoint_secret',
        'paypal_email',
    ];

    /*
     * Récupérer la currency
     */
    public function currency(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

}
