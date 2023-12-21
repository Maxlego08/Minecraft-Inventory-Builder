<?php

namespace App\Models\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property string $old_name
 * @property string $new_name
 * @property User $user
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class NameChangeHistory extends Model
{
    protected $fillable = ['user_id', 'old_name', 'new_name'];

    protected $table = 'user_name_change_histories';

    /**
     * L'utilisateur
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
