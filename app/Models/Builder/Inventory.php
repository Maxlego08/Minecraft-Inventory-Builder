<?php

namespace App\Models\Builder;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $file_name
 * @property int $size
 */
class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'name', 'size', 'user_id', 'update_interval', 'clear_inventory', 'folder_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
