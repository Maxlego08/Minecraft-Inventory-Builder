<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Download;
use App\Models\Resource\Resource;
use App\Models\Resource\Version;
use App\Models\UserLog;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResourceDownloadController extends Controller
{

    /**
     * Download a file
     *
     * @param Resource $resource
     * @param Version $version
     * @return StreamedResponse|RedirectResponse
     */
    public function download(Resource $resource, Version $version): StreamedResponse|RedirectResponse
    {

        if ($resource->is_pending && (Auth::guest() || !$resource->isModerator())) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.pending.title'), __('resources.view.errors.pending.content'), 5000));
        }

        if ($resource->is_deleted && (Auth::guest() || !user()->role->isModerator())) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.deleted.title'), __('resources.view.errors.deleted.content'), 5000));
        }

        if ($resource->id != $version->resource_id) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.download.errors.same.title'), __('resources.download.errors.same.content'), 5000));
        }

        $user = user();
        if ($user->role->is_banned) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.download.errors.ban.title'), __('resources.download.errors.ban.content'), 5000));
        }

        if ($resource->price != 0 && !$user->hasAccessWithoutCache($resource)) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.download.errors.purchase.title'), __('resources.download.errors.purchase.content'), 5000));
        }

        $key = "download::$user->id";
        if (Cache::has($key)) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.download.errors.cache.title'), __('resources.download.errors.cache.content'), 5000));
        }

        Cache::put($key, 'cooldown', 15);
        if (empty(Download::hasAlreadyDownload($version, $user))) {
            Download::create(['version_id' => $version->id, 'user_id' => $user->id]);
            $version->update(['download' => $version->download + 1]);
            $resource->clear('count.download');
        }

        try {
            $path = "$resource->id/{$version->file->file_name}.{$version->file->file_extension}";

            userLog("Téléchargement de la resource $resource->id", UserLog::COLOR_SUCCESS, UserLog::ICON_FILE);
            $user->enableNotification($resource);

            return Storage::disk('plugins')->download($path, "{$version->file_name}.{$version->file->file_extension}");
        } catch (Exception) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.download.errors.other.title'), __('resources.download.errors.other.content'), 5000));
        }

    }

}
