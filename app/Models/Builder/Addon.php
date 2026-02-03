<?php

namespace App\Models\Builder;

use App\Models\Resource\Resource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property boolean $is_official
 * @property int $resource_id
 * @property Resource $resource
 * @property ButtonType[] $buttonTypes
 * @property ActionType[] $actionTypes
 */
class Addon extends Model
{
    use HasFactory;

    protected $table = 'inventory_addons';
    protected $fillable = [
        'name',
        'resource_id',
        'description',
        'is_official'
    ];

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }

    public function buttonTypes(): HasMany
    {
        return $this->hasMany(ButtonType::class, 'addon_id');
    }

    public function actionTypes(): HasMany
    {
        return $this->hasMany(ActionType::class, 'addon_id');
    }
}
