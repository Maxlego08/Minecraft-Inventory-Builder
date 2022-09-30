<?php

namespace App\Models\Alert;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $level
 * @property string $content
 * @property string $link
 * @property Carbon|null $opened_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * Class Notification
 * @package App\Models
 * @method static AlertUser create(array $values)
 */
class AlertUser extends Model
{
    use HasFactory;

    protected $table = "alerts_user";

    protected $fillable = ['user_id', 'level', 'content', 'link', 'opened_at',];

    /**
     * Permet d'obtenir l'utilisateur
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark the notification as read.
     *
     * @return void
     */
    public function markAsRead()
    {
        if ($this->opened_at === null) {
            $this->update(['opened_at' => now()]);
        }
    }

}
