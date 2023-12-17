<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 */
class NameColor extends Model
{
    use HasFactory;

    protected $table = "user_name_colors";

    protected $fillable = ['code'];

}
