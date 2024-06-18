<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryButtonAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_button_id',
        'inventory_action_type_id',
        'data'
    ];

}
