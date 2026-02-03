<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $name
 * @property string $description
 * @property string $documentation_url
 * @property string $example
 * @property boolean $is_zmenu_plus
 * @property Addon $addon
 * @property ActionTypeContent[] $contents
 */
class ActionType extends Model
{
    use HasFactory;

    protected $table = 'inventory_action_types';

    protected $fillable = [
        'id', 'name', 'description', 'addon_id', 'example', 'documentation_url', 'is_zmenu_plus'
    ];

    /**
     * Retourne la liste des contenus pour les actions
     *
     * @return HasMany
     */
    public function contents(): HasMany
    {
        return $this->hasMany(ActionTypeContent::class, 'type_id');
    }

    /**
     * @return BelongsTo
     */
    public function addon(): BelongsTo
    {
        return $this->belongsTo(Addon::class, 'addon_id');
    }
}
