<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property string $currency
 * @property string $pk_live
 * @property string $sk_live
 * @property string $endpoint_secret
 * @property string $paypal_email
 */
class UserPaymentInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency',
        'user_id',
        'pk_live',
        'sk_live',
        'endpoint_secret',
        'paypal_email',
    ];
}
