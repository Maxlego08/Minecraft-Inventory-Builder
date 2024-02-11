<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButtonType extends Model
{
    use HasFactory;

    protected $table = 'inventory_button_types';
    protected $fillable = [
        'name', 'description', 'addon_id', 'example'
    ];

}
