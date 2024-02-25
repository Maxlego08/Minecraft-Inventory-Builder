<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $key
 */
class ButtonTypeContent extends Model
{
    use HasFactory;

    protected $table = 'inventory_button_type_contents';

    protected $fillable = [
        'type_id', 'data_type', 'key', 'description', 'documentation_url'
    ];

}
