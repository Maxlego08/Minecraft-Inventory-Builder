<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Resource;
use App\Models\Resource\Version;
use App\Models\UserLog;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ResourceVersionController extends Controller
{
    /**
     * Show a resource
     *
     * @param string $slug
     * @param Resource $resource
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse
     */
    public function index(string $slug, Resource $resource): \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse
    {

        if ($resource->is_pending && (Auth::guest() || !$resource->isModerator())) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.pending.title'), __('resources.view.errors.pending.content'), 5000));
        }

        if ($resource->is_deleted && (Auth::guest() || !user()->role->isModerator())) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.deleted.title'), __('resources.view.errors.deleted.content'), 5000));
        }

        if ($slug != $resource->slug()) return Redirect::route('resources.versions', ['resource' => $resource->id, 'slug' => $resource->slug()]);

        $versions = $resource->versions()->with('reviews')->orderBy('created_at', 'desc')->paginate(30);

        return view('resources.pages.versions', ['resource' => $resource, 'versions' => $versions]);
    }

    /**
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function indexById(Resource $resource): RedirectResponse
    {
        return Redirect::route('resources.versions', ['resource' => $resource->id, 'slug' => $resource->slug()]);
    }

    /**
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

        $this->validate($request, [
            'version_name' => ['required', 'string', 'min:3', 'max:100'],
            'version_version' => ['required', 'string', 'min:3', 'max:25'],
            'upload_file' => 'required|mimes:jar,zip|max:4096', // jar = application/octet-stream - zip = application/x-zip-compressed;
            'description' => 'required',
        ]);

        $file = $request->file('upload_file');
        $user = user();
        $storedFile = $this->storeFile($user, $resource, $file);
        $fileName = str_replace('.' . $this->getFileExtension($file), '', $file->getClientOriginalName());

        $version = Version::create([
            'version' => $request['version_version'],
            'resource_id' => $resource->id,
            'title' => $request['version_name'],
            'description' => $request['description'],
            'download' => 0,
            'file_id' => $storedFile->id,
            'file_name' => $fileName,
        ]);
        $resource->update(['version_id' => $version->id]);

        $resource->clearVersionUpdate();

        // Ajouter les notifications

        userLog("Mise à jour de la resource $resource->id", UserLog::COLOR_SUCCESS, UserLog::ICON_FILE);

        return Redirect::route('resources.view', ['resource' => $resource, 'slug' => $resource->slug()])->with('toast', createToast('success', __('resources.updates.success.title'), __('resources.updates.success.content'), 5000));
    }

}
