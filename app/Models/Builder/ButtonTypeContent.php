<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $type_id
 * @property string $key
 * @property string $data_type
 */
class ButtonTypeContent extends Model
{
    use HasFactory;

    protected $table = 'inventory_button_type_contents';

    protected $fillable = [
        'type_id', 'data_type', 'key', 'description', 'documentation_url'
    ];
}
