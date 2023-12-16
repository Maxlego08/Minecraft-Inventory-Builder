<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $currency
 * @property string $icon
 */
class Currency extends Model
{
    use HasFactory;

    protected $table = "payment_currencies";

    protected $fillable = [
        'currency',
        'icon'
    ];
}
