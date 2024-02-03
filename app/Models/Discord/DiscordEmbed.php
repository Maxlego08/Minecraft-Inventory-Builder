<?php

namespace App\Models\Discord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $title
 * @property string $color
 * @property string $footer
 * @property string $url_embed
 * @property string $description
 * @property string $thumbnail
 */
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
