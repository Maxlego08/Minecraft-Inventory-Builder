<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $type
 * @property string $name
 */
class InventoryVisibility extends Model
{
    use HasFactory;

    const PRIVATE = 0;
    const UNLISTED = 1;
    const PUBLIC = 2;


    protected $fillable = ['type', 'name'];

}
