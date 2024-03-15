<?php

namespace App\Models\Builder;

use App\Models\Resource\Resource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property string $description
 * @property Resource $resource
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

}
