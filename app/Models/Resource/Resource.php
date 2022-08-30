<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $table = "resource_resources";

    protected $fillable = [
        'category_id',
        'user_id',
        'image_id',
        'name',
        'price',
        'description',
        'tag',
        'is_display',
        'is_pending',
        'source_code_link',
        'donation_link',
        'discord_server_id',
        'bstats_id',
        'required_dependencies',
        'optional_dependencies',
        'supported_languages',
    ];

}
