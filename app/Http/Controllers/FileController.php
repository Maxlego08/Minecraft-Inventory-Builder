<?php

namespace App\Http\Controllers;

use App\Exceptions\FileExtensionException;
use App\Exceptions\UserFileFullException;
use App\Models\File;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class FileController extends Controller
{

    public const IMAGE_WIDTH = 1000;

    /**
     *
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $files = user()->images()->sortByDesc('file_size');
        return view('members.media.index', ['images' => $files,]);
    }

    /**
     * @param Request $request
     * @return string|false
     * @throws ValidationException
     * @throws FileExtensionException
     */
    public function uploadImage(Request $request): bool|string
    {
        $user = user();
        $role = $user->role;

        $this->validate($request, ['images.*' => $role->getImageValidator()]); // Validation pour chaque image

        $files = $request->file('images');
        $uploadedImages = []; // Stocker les informations des images téléchargées

        foreach ($files as $file) {
            $image = Image::make($file);
            try {
                $media = $this->storeImage($user, $file, $image, true, true);
                userLog("Création de l'image $media->id (JS)", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);
                $uploadedImages[] = ['url' => $media->getPath(), 'name' => "$media->file_name.$media->file_extension", 'file_name' => Str::limit("$media->file_name.$media->file_extension", 15)];
            } catch (UserFileFullException) {
                return json_encode(['toast' => createToast('error', 'Impossible to create an image', 'You dont have enough space for upload a new image.', 5000), 'status' => 'error']);
            }
        }

        return json_encode(['toast' => createToast('success', 'New images', "You just create new images", 2000), 'status' => 'success', 'elements' => $uploadedImages]);
    }

    /**
     * @param Request $request
     * @return File|RedirectResponse
     * @throws ValidationException
     * @throws FileExtensionException
     * @throws UserFileFullException
     */
    public function uploadImageForm(Request $request): File|RedirectResponse
    {
        $user = user();
        $role = $user->role;

        $this->validate($request, ['images.*' => $role->getImageValidator()]);

        $files = $request->file('images');
        foreach ($files as $file) {
            $image = Image::make($file);
            $media = $this->storeImage($user, $file, $image, true, true);
            userLog("Création de l'image $media->id (FORM)", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);
        }

        return Redirect::back()->with('toast', createToast('success', __('images.upload.title'), __('images.upload.content'), 5000));
    }

    /**
     * Delete a file
     *
     * @param File $file
     * @return RedirectResponse
     */
    public function delete(File $file): RedirectResponse
    {
        if ($file->user_id != user()->id) {
            return Redirect::back()->with('toast', createToast('error', __('images.delete.errors.permission.title'), __('images.delete.errors.permission.content'), 5000));
        }

        if (!$file->is_deletable) {
            return Redirect::back()->with('toast', createToast('error', __('images.delete.errors.file.title'), __('images.delete.errors.file.content'), 5000));
        }

        Storage::disk('public')->delete("images/$file->file_name.$file->file_extension");
        $file->deleteCache();
        $file->delete();
        userLog('Suppression du fichier ' . $file->id, UserLog::COLOR_DANGER, UserLog::ICON_REMOVE);

        return Redirect::back()->with('toast', createToast('success', __('images.delete.success.title'), __('images.delete.success.content'), 5000));
    }

    /**
     * Delete files
     *
     * @param Request $request
     * @return bool|string
     */
    public function deleteAll(Request $request): bool|string
    {

        $selectedImages = $request->input('images', []);
        foreach ($selectedImages as $selectedImage) {
            $file = File::find($selectedImage);

            if ($file->user_id != user()->id || !$file->is_deletable) continue;

            Storage::disk('public')->delete("images/$file->file_name.$file->file_extension");
            $file->deleteCache();
            $file->delete();
            userLog('Suppression du fichier ' . $file->id, UserLog::COLOR_DANGER, UserLog::ICON_REMOVE);
        }

        return json_encode([
            'toast' =>  createToast('success', __('images.delete.success.title'), __('images.delete.success.content'), 5000)
        ]);
    }


    public function preview(File $file)
    {
        return $file->getFirstImage();
    }
}
