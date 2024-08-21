<?php

namespace App\Http\Controllers\Resource;

use App\Exceptions\FileExtensionException;
use App\Exceptions\UserFileFullException;
use App\Http\Controllers\Controller;
use App\Models\Resource\Resource;
use App\Models\UserLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class ResourceIconController extends Controller
{

    /**
     * Edit resource icon
     *
     * @param Request $request
     * @param Resource $resource
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request, Resource $resource): RedirectResponse
    {
        if (!$resource->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.permission.title'), __('resources.view.errors.permission.content'), 5000));
        }

        $user = user();

        $this->validate($request, [
            'icon' => $user->role->getImageValidator(),
        ]);

        $imageFile = $request->file('icon');
        $image = Image::make($imageFile);
        $icon = $resource->icon;

        try {
            $media = $this->storeImage($user, $imageFile, $image, false, true, 50, 50);

            $disk = Storage::disk('public');
            $path = $user->getImagesPath();
            $filePath = $path . $icon->file_name . '.' . $icon->file_extension;
            $disk->delete($filePath);

        } catch (FileExtensionException|UserFileFullException $e) {
            return Redirect::back()->withInput($request->input())->with('toast', createToast('error', 'Error !', 'Your resource icon is not right', 5000));
        }

        $resource->update([
            'image_id' => $media->id
        ]);
        $icon->delete();

        $resource->clear('icon.path');
        $resource->clear('resource.icon');

        userLog("Création de l'icon de la resource $resource->id", UserLog::COLOR_SUCCESS, UserLog::ICON_FILE);

        return Redirect::route('resources.view', ['resource' => $resource, 'slug' => $resource->slug()])->with('toast', createToast('success', __('resources.edit.icon_modal.success.title'), __('resources.edit.icon_modal.success.content'), 5000));
    }
}
