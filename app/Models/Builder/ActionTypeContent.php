<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionTypeContent extends Model
{
    use HasFactory;

    protected $table = 'inventory_action_type_contents';

    protected $fillable = [
        'type_id', 'data_type', 'key', 'description', 'value'
    ];
}
