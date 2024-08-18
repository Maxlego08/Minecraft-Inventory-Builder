<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $version
 * @property string $minecraft_version
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon released_at
 * @method static MinecraftVersion create(array $values)
 */
class MinecraftVersion extends Model
{
    use HasFactory;

    protected $table = "versions";

    protected $fillable = ['version', 'minecraft_version', 'released_at'];

    protected $casts = ['released_at' => 'datetime'];
}
