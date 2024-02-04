<?php

namespace App\Http\Controllers;

use App\Code\BBCodeUtils;
use App\Exceptions\FileExtensionException;
use App\Exceptions\UserFileFullException;
use App\Models\File;
use App\Models\MinecraftVersion;
use App\Models\Resource\Category;
use App\Models\Resource\Resource;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Permet de transformer le bbcode en html
     *
     * @param string $bbcode
     * @return string
     */
    protected function bbcode(string $bbcode): string
    {
        return BBCodeUtils::renderAndPurify($bbcode);
    }

    /**
     * Retourne les versions de minecraft
     *
     * @return mixed
     */
    protected function versions(): mixed
    {
        return Cache::remember('versions', 60 * 10, function () {
            return MinecraftVersion::orderBy('released_at')->get();
        });
    }

    /**
     * Permet d'avoir un cache sur les catégories
     * Le cache est par défaut de 24 heures, sauf si une action sur les resources est effectué, alors le cache sera oublié et calculer de nouveau
     *
     * @return mixed
     */
    protected function categories(): mixed
    {
        return Cache::remember('categories', 60, function () {

            $categories = Category::all(); // On va récupérer toutes les catégories
            $arrayCategories = []; // Tableau qui va contenir les categories

            foreach ($categories as $category) {
                $arrayCategories[$category->name] = ['count' => $category->countResources(), 'sub' => $category->category_id == null,];
            }

            return $arrayCategories;
        });
    }


    /**
     * Permet de supprimer le cache des catégories
     *
     * @return void
     */
    protected function destroyCacheCategories(): void
    {
        Cache::forget('categories');
    }

    /**
     * @param User $user
     * @param UploadedFile $uploadedFile
     * @param Image $image
     * @param bool $isDeletable
     * @param bool $returnMedia
     * @param null|int $width
     * @param mixed|null $height
     * @return File|RedirectResponse
     * @throws FileExtensionException
     * @throws UserFileFullException
     */
    protected function storeImage(User $user, UploadedFile $uploadedFile, Image $image, bool $isDeletable = true, bool $returnMedia = false, null|int $width = FileController::IMAGE_WIDTH, mixed $height = null): File|RedirectResponse
    {

        $extension = $this->getImageExtension($image);

        if ($image->width() >= $width && $extension !== 'gif') $this->resize($image, $width, $height);

        if (!$isDeletable) {
            $this->userHasEnoughPlace($image);
        }

        $file = $this->finalStorage($user, $uploadedFile, $isDeletable, $image, $extension);

        if (!$returnMedia) {
            return Redirect::route('members.medias.index')->with('toast', createToast('success', 'New image', "You just create a new image", 2000));
        }

        return $file;
    }

    /**
     * Get the image extension
     *
     * @param Image $image
     * @return string
     * @throws FileExtensionException
     */
    protected function getImageExtension(Image $image): string
    {
        $mime = $image->mime();
        if ($mime == 'image/jpeg') {
            return 'jpg';
        } elseif ($mime == 'image/png') {
            return 'png';
        } elseif ($mime == 'image/gif') {
            return 'gif';
        } else {
            throw new FileExtensionException();
        }
    }

    /**
     * Resize image
     *
     * @param Image $image
     * @param null|int $width
     * @param null|int $height
     */
    protected function resize(Image $image, null|int $width = 220, null|int $height = 110)
    {
        $image->resize($width, $height, function ($constraint) use ($height) {
            if ($height === null) {
                $constraint->aspectRatio();
                $constraint->upsize();
            }
        });
    }

    /**
     * Check if the user has enough space in their storage
     *
     * @param Image $image
     * @throws UserFileFullException
     */
    protected function userHasEnoughPlace(Image $image)
    {
        $user = user();
        $totalSize = $user->getDiskSize() + $image->filesize();
        if ($totalSize > user()->role->total_size) throw new UserFileFullException();
    }

    /**
     * @param User $user
     * @param UploadedFile $uploadedFile
     * @param bool $isDeletable
     * @param Image $image
     * @param string $extension
     * @return File
     */
    protected function finalStorage(User $user, UploadedFile $uploadedFile, bool $isDeletable, Image $image, string $extension): File
    {
        $fileName = Str::random(40);
        $path = $user->getImagesPath();
        $file = $path . $fileName . '.' . $extension;

        $disk = Storage::disk('public');
        $disk->makeDirectory($path);
        if ($extension === 'gif') {
            $uploadedFile->storeAs($path, $fileName . '.' . $extension, 'public');
        } else {
            $disk->put($file, $image->encode(null, 75));
        }

        $size = $disk->size($file);

        return File::create(['user_id' => $user->id, 'file_extension' => $extension, 'file_size' => $size, 'file_name' => $fileName, 'is_deletable' => $isDeletable,]);
    }

    /**
     * Store a resource file
     *
     * @param User $user
     * @param Resource $resource
     * @param UploadedFile $file
     * @return File
     */
    protected function storeFile(User $user, Resource $resource, UploadedFile $file): File
    {
        $fileName = Str::random(40);
        $extension = $this->getFileExtension($file);
        $path = $resource->id;

        $filePath = "$path/$fileName.$extension";

        $disk = Storage::disk('plugins');
        $file->storeAs($path, "$fileName.$extension", "plugins");

        $size = $disk->size($filePath);

        return File::create(['user_id' => $user->id, 'file_extension' => $extension, 'file_size' => $size, 'file_name' => $fileName, 'is_deletable' => false]);
    }

    /**
     * Find file extension
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function getFileExtension(UploadedFile $file): string
    {
        $mineType = $file->getClientMimeType();
        $extensionFile = "jar";
        switch ($mineType) {
            case 'application/octet-stream':
                $extensionFile = "jar";
                break;
            case 'application/x-zip-compressed':
                $extensionFile = "zip";
                break;
        }
        return $extensionFile;
    }

}
