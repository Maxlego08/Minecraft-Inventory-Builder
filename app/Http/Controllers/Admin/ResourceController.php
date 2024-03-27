<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert\AlertUser;
use App\Models\File;
use App\Models\Resource\Resource;
use App\Models\UserLog;
use App\Payment\utils\Resources\ResourceCreate;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ResourceController extends Controller
{
    /**
     * Display resource
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $resources = Resource::paginate();
        return view('admins.resources.index', [
            'resources' => $resources,
        ]);
    }

    /**
     * Display pending resource
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function pending(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $resources = Resource::where('is_pending', true)->paginate();
        return view('admins.resources.pending', [
            'resources' => $resources,
        ]);
    }

    /**
     * Accept a resource
     *
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function accept(Resource $resource): RedirectResponse
    {
        $resource->update([
            'is_pending' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        createAlert($resource->user_id, $resource->name, AlertUser::ICON_SUCCESS, AlertUser::SUCCESS, 'alerts.alerts.resources.accepted');
        userLog("Ressource accepté $resource->name ($resource->id)", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        Cache::forget('pending_resources');
        Cache::forget('resources:mostResources');

        event(new ResourceCreate($resource, $resource->user));

        return Redirect::route('admin.resources.pending')->with('toast', createToast('success', 'Ressource acceptée !', 'Vous venez d\'accepter la ressource ' . $resource->name . '.' . $resource->id, 5000));
    }

    /**
     * @param Request $request
     * @param Resource $resource
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function refuse(Request $request, Resource $resource): RedirectResponse
    {

        $this->validate($request, [
            'reason' => ['required'],
        ]);

        $resource->update([
            'version_id' => null,
        ]);

        $file = $resource->icon;
        $fileId = $file->id;
        Storage::disk('public')->delete("images/$file->file_name.$file->file_extension");

        foreach ($resource->versions()->get() as $version) {
            $file = $version->file;
            Storage::disk('plugins')->delete("$resource->id/$file->file_name.$file->file_extension");
            foreach ($version->downloads()->get() as $download) $download->delete();
            $version->delete();
            $file->delete();
        }

        foreach ($resource->buyers as $buyer) {
            $buyer->delete();
        }

        foreach ($resource->reviews as $review) {
            $review->delete();
        }

        $resource->delete();
        File::where('id', $fileId)->delete();
        Storage::disk('plugins')->deleteDirectory($resource->id);

        createAlert($resource->user_id, $resource->name, AlertUser::ICON_TRASH, AlertUser::DANGER, 'alerts.alerts.resources.deleted');
        userLog("Ressource refusé $resource->name ($resource->id)", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);

        Cache::forget('pending_resources');
        Cache::forget('resources:mostResources');

        return Redirect::route('admin.resources.pending')->with('toast', createToast('success', 'Ressource refusée !', 'Vous venez de refuser la ressource ' . $resource->name . '.' . $resource->id, 5000));
    }

    /**
     * Afficher les informations sur une resources
     *
     * @param Resource $resource
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show(Resource $resource): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admins.resources.view', [
            'resource' => $resource,
        ]);
    }


}
