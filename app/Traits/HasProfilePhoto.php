<?php

namespace App\Traits;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Psy\Util\Str;

trait HasProfilePhoto
{

    /**
     * Update the user's profile photo.
     *
     * @param UploadedFile $photo
     * @return void
     */
    public function updateProfilePhoto(UploadedFile $photo): void
    {
        tap($this->profile_photo_path, function ($previous) use ($photo) {

            $disk = Storage::disk($this->profilePhotoDisk());
            $pathSmall = $this->saveImage($photo, true);
            $pathLarge = $this->saveImage($photo, false);

            $this->forceFill(['profile_photo_path' => $pathSmall, 'profile_photo_path_large' => $pathLarge,])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
                Storage::disk($this->profilePhotoDisk())->delete($this->profile_photo_path_large);
            }
        });
    }

    /**
     * Update the user's profile photo.
     *
     * @param UploadedFile $photo
     * @return void
     */
    public function updateBannerPhoto(UploadedFile $photo): void
    {
        tap($this->banner_photo_path, function ($previous) use ($photo) {

            $disk = Storage::disk($this->profilePhotoDisk());
            $fileName = $photo->hashName();
            $image = Image::make($photo);
            $image->resizeCanvas(1420, 300);

            $path = "profile-photos/b/" . $fileName;
            $disk->put($path, $image->encode(null, 75));

            $this->forceFill(['banner_photo_path' => $path])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function profilePhotoDisk(): string
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.profile_photo_disk', 'public');
    }

    /**
     * Save user image in 2 different sizes
     *
     * @param UploadedFile $photo
     * @param bool $isSmall
     * @return string
     */
    private function saveImage(UploadedFile $photo, bool $isSmall): string
    {
        $disk = Storage::disk($this->profilePhotoDisk());
        $fileName = $photo->hashName();
        $image = Image::make($photo);
        $size = $isSmall ? 50 : 150;
        $image->resize($size, $size);

        $subFolder = $isSmall ? 's' : 'l';
        $path = "profile-photos/$subFolder/" . $fileName;
        $disk->put($path, $image->encode(null, 75));

        return $path;
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto(): void
    {

        if (is_null($this->profile_photo_path)) {
            return;
        }

        Storage::disk($this->profilePhotoDisk())->delete($this->profile_photo_path);
        Storage::disk($this->profilePhotoDisk())->delete($this->profile_photo_path_large);

        $this->forceFill(['profile_photo_path' => null, 'profile_photo_path_large' => null])->save();
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteBannerPhoto(): void
    {

        if (is_null($this->banner_photo_path)) {
            return;
        }

        Storage::disk($this->profilePhotoDisk())->delete($this->banner_photo_path);

        $this->forceFill(['banner_photo_path' => null])->save();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_photo_path ? Storage::disk($this->profilePhotoDisk())->url($this->profile_photo_path) : $this->defaultProfilePhotoUrl();
    }

    /**
     * Get the URL to the user's profile photo large.
     *
     * @return string
     */
    public function getProfilePhotoLargeUrlAttribute(): string
    {
        return $this->profile_photo_path_large ? Storage::disk($this->profilePhotoDisk())->url($this->profile_photo_path_large) : $this->defaultProfilePhotoUrl();
    }

    /**
     * Get the URL to the user's profile photo large.
     *
     * @return string
     */
    public function getBannerUrlAttribute(): string
    {
        return Storage::disk($this->profilePhotoDisk())->url($this->banner_photo_path);
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultProfilePhotoUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
    }

}
