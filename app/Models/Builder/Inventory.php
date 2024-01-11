<?php

namespace App\Models\Builder;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property int $size
 */
class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size', 'user_id', 'updateInterval', 'clearInventory'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
