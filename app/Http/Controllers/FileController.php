<?php

namespace App\Http\Controllers;

use App\Exceptions\FileExtensionException;
use App\Exceptions\UserFileFullException;
use App\Models\File;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
        $files = user()->images();
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

        $this->validate($request, ['image' => $role->getImageValidator()]);

        $file = $request->file('image');
        $image = Image::make($file);
        try {
            $media = $this->storeImage($user, $file, $image, true, true);
            return json_encode(['toast' => createToast('success', 'New image', "You just create a new image", 2000), 'status' => 'success', 'element' => ['url' => $media->getPath(), 'name' => "$media->file_name.$media->file_extension"]]);
        } catch (UserFileFullException) {
            return json_encode(['toast' => createToast('error', 'Impossible to create an image', 'You dont have enough space for upload a new image.', 5000), 'status' => 'error']);
        }
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

        $this->validate($request, ['image' => $role->getImageValidator()]);

        $file = $request->file('image');
        $image = Image::make($file);
        $this->storeImage($user, $file, $image, true, true);

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
        $file->delete();

        return Redirect::back()->with('toast', createToast('success', __('images.delete.success.title'), __('images.delete.success.content'), 5000));
    }
}
