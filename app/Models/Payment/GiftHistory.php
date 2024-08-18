<?php

namespace App\Models\Payment;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gift_id'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function gift(): BelongsTo
    {
        return $this->belongsTo(Gift::class);
    }

    /**
     * @param $gift
     * @param $user_id
     * @return bool
     */
    public static function canUse($gift, $user_id): bool
    {
        $history = GiftHistory::where('gift_id', $gift->id)->where('user_id', $user_id)->first();
        return !isset($history);
    }
}
