<?php

namespace App\Models\Discord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscordEmbed extends Model
{
    use HasFactory;

    protected $fillable = [
        'discord_id',
        'title',
        'color',
        'footer',
        'url_embed',
        'description',
        'thumbnail',
    ];

}
