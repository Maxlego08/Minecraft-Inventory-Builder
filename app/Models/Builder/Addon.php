<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;

    protected $table = 'inventory_addons';
    protected $fillable = [
        'name',
        'resource_id',
        'description'
    ];

}
