<?php

namespace App\Models\Payment;

use App\Models\Resource\Resource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool $active
 * @property int $used
 * @property int $max_use
 * @property string $code
 * @property int $resource_id
 * @property double $reduction
 */
class Gift extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'resource_id',
        'active',
        'max_use',
        'used',
        'reduction'
    ];

    /**
     * La resource lié au gift.js
     *
     * @return BelongsTo
     */
    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

}

