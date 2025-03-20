<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $type_id
 * @property string $data_type
 * @property string $key
 */
class ActionTypeContent extends Model
{
    use HasFactory;

    protected $table = 'inventory_action_type_contents';

    protected $fillable = [
        'type_id', 'data_type', 'key', 'description', 'value'
    ];
}
