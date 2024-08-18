<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property double $version
 * @method static ItemFlag create(array $values)
 */
class ItemFlag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'version'];
}

