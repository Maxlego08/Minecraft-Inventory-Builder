<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    const ZIP = ['zip'];
    const IMAGE = ['png', 'jpg', 'gif'];
    const JAR = ['jar'];

    protected $fillable = [
        'user_id',
        'file_size',
        'file_extension',
        'file_name',
        'is_deletable',
    ];

}
