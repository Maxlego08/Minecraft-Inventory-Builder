<?php

namespace App\Models\Builder;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $file_name
 * @property int $size
 * @property InventoryButton[] $buttons
 */
class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'name', 'size', 'user_id', 'update_interval', 'clear_inventory', 'folder_id'];


    /**
     * Returns the folder or inventory
     *
     * @return BelongsTo
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Returns the inventory user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retourne la liste des boutons de l'inventaire
     *
     * @return HasMany
     */
    public function buttons(): HasMany
    {
        return $this->hasMany(InventoryButton::class);
    }

}
