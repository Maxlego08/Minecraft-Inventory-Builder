<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $image_name
 * @property string $name
 * @property string $head_url
 * @property int $url_id
 * @property int $id
 * @property string $image_url
 */
class Head extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url', 'head_url', 'name', 'image_name', 'url', 'url_id', 'id'
    ];
}
