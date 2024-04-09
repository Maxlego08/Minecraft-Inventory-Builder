<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryVisibility extends Model
{
    use HasFactory;

    const PRIVATE = 0;
    const UNLISTED = 1;
    const PUBLIC = 2;


    protected $fillable = ['type', 'name'];

}
