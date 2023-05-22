<?php

namespace App\Models\Resource;

use App\Models\Payment\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $payment_id
 * @property int $resource_id
 * @property Payment $payment
 */
class Access extends Model
{
    use HasFactory;

    protected $table = "resource_accesses";

    protected $fillable = [
        'resource_id',
        'user_id',
        'payment_id',
    ];

    /**
     * User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    /**
     * @return BelongsTo
     */
    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }

    public function getPrice(){
        if ($this->payment_id == null) return __('resources.buyers.free');
        else return $this->payment->price;
    }

}
