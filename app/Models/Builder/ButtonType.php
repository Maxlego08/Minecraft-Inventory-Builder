<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $name
 * @property Addon $addon
 * @property ButtonTypeContent[] $contents
 */
class ButtonType extends Model
{
    use HasFactory;

    protected $table = 'inventory_button_types';
    protected $fillable = [
        'name', 'description', 'addon_id', 'example'
    ];

    /**
     * Returns all content of a button type
     *
     * @return HasMany
     */
    public function contents(): HasMany
    {
        return $this->hasMany(ButtonTypeContent::class, 'type_id');
    }

    public function addon(): BelongsTo
    {
        return $this->belongsTo(Addon::class, 'addon_id');
    }

}
