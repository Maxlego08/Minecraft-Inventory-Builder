<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Head extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url', 'head_url', 'name', 'image_name', 'url', 'url_id'
    ];
}
