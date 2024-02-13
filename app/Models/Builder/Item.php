<?php

namespace App\Models\Builder;

use App\Models\MinecraftVersion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $material
 * @method static Item create(array $values)
 */
class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'css', 'minecraft_id', 'version_id', 'material', 'old_material', 'max_stack_size'];

    /**
     * @return BelongsTo
     */
    public function version(): BelongsTo
    {
        return $this->belongsTo(MinecraftVersion::class, 'version_id');
    }

}
