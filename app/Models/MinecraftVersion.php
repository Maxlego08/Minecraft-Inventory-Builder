<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static MinecraftVersion create(array $values)
 */
class MinecraftVersion extends Model
{
    use HasFactory;

    protected $table = "versions";

    protected $fillable = ['version', 'minecraft_version', 'released_at'];
}
