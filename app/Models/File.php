<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Imagick;
use ImagickException;
use Intervention\Image\Facades\Image;

/**
 * Class File
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property int $file_size
 * @property string $file_extension
 * @property string $file_name
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property bool $is_deletable
 * @property User $user
 */
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
        'file_upload_name',
        'file_name',
        'is_deletable',
    ];

    /**
     * Return the user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get image path
     *
     * @return string
     */
    public function getPath(): string
    {
        return url("storage/images/$this->file_name.$this->file_extension");
    }

    /**
     * @throws ImagickException
     */
    public function getFirstImage(): Response
    {
        $cacheFolder = 'public/cache/images';
        $cacheFileName = $cacheFolder . '/' . $this->file_name . '_50.png'; 

        if (Storage::exists($cacheFileName)) {
            $cachedImagePath = storage_path('app/' . $cacheFileName);
            $imageContent = file_get_contents($cachedImagePath);
        } else {
            $path = storage_path("app/public/images/$this->file_name.$this->file_extension");

            if ($this->file_extension === 'gif') {
                $imagick = new Imagick($path);
                $imagick->setIteratorIndex(0);
                $imagick->setImageFormat('png');

                $width = $imagick->getImageWidth();
                $height = $imagick->getImageHeight();
                $newHeight = 50;
                $newWidth = ($width / $height) * $newHeight;
                $imagick->resizeImage($newWidth, $newHeight, Imagick::FILTER_LANCZOS, 1);

                $imageContent = $imagick->getImageBlob();
            } else {
                $img = Image::make($path);
                $img->resize(null, 50, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $imageContent = $img->encode('png')->getEncoded();
            }

            Storage::put($cacheFileName, $imageContent);
        }

        // Créer et retourner la réponse avec l'image
        $response = new Response($imageContent);
        $response->header('Content-Type', 'image/png');

        return $response;
    }

}
