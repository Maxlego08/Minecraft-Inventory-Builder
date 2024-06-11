<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionType extends Model
{
    use HasFactory;

    protected $table = 'inventory_action_types';

    protected $fillable = [
        'name', 'description', 'addon_id', 'example'
    ];
}
