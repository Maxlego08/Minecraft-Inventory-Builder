<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Version create(array $values)
 */
class Version extends Model
{
    use HasFactory;

    protected $fillable = ['version', 'minecraft_version', 'released_at'];
}
