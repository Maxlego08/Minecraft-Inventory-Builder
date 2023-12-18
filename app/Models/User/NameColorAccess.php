<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User $user
 * @property NameColor $color
 */
class NameColorAccess extends Model
{
    use HasFactory;

    protected $table = "user_name_color_accesses";

    protected $fillable = ['user_id', 'color_id', 'payment_id'];

    /**
     * Retourne la couleur
     *
     * @return BelongsTo
     */
    function color(): BelongsTo
    {
        return $this->belongsTo(NameColor::class, 'color_id');
    }

    /**
     * Retourne l'utilisateur
     *
     * @return BelongsTo
     */
    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
