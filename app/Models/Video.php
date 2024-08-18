<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['url'];

    static function getYoutubeVideoId($url)
    {
//expression régulière pour capturer l'ID de la vidéo
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, $url, $matches);
        //retourne l'ID de la vidéo ou null si aucune correspondance n'a été trouvée
        return isset($matches[1]) ? $matches[1] : null;
    }


/* // Exemple d'utilisation
$youtubeUrl1 = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
$youtubeUrl2 = "https://youtu.be/dQw4w9WgXcQ";


$videoId1 = getYouTubeVideoId($youtubeUrl1);
$videoId2 = getYouTubeVideoId($youtubeUrl2);*/

    public static function getRandomVideo()
    {
        return self::inRandomOrder()->first();
    }

    public static function getRandomYoutubeVideoId()
    {
        $randomVideo = self::getRandomVideo();
        return $randomVideo ? self::getYoutubeVideoId($randomVideo->url) : null;
    }

}
