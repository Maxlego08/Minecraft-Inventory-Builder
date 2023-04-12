<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Download;
use App\Models\Resource\Resource;
use App\Models\Resource\Version;
use Exception;
use Illuminate\Http\RedirectResponse;
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

        if ($resource->id != $version->resource_id) {
            return Redirect::back()->with('toast', createToast('error', __('resources.download.errors.same.title'), __('resources.download.errors.same.content'), 5000));
        }

        $user = user();
        if ($user->role->is_banned) {
            return Redirect::back()->with('toast', createToast('error', __('resources.download.errors.ban.title'), __('resources.download.errors.ban.content'), 5000));
        }

        if ($resource->price != 0 && !$user->hasAccess($resource)) {
            return Redirect::back()->with('toast', createToast('error', __('resources.download.errors.purchase.title'), __('resources.download.errors.purchase.content'), 5000));
        }

        $key = "download::$user->id";
        if (Cache::has($key)) {
            return Redirect::back()->with('toast', createToast('error', __('resources.download.errors.cache.title'), __('resources.download.errors.cache.content'), 5000));
        }

        Cache::put($key, 'cooldown', 15);
        if (empty(Download::hasAlreadyDownload($version, $user))) {
            Download::create(['version_id' => $version->id, 'user_id' => $user->id]);
            $version->update(['download' => $version->download + 1]);
            $resource->clear('count.download');
        }

        try {
            $path = "$resource->id/{$version->file->file_name}.{$version->file->file_extension}";
            return Storage::disk('plugins')->download($path, "{$version->file_name}d.{$version->file->file_extension}");
        } catch (Exception) {
            return Redirect::back()->with('toast', createToast('error', __('resources.download.errors.other.title'), __('resources.download.errors.other.content'), 5000));
        }

    }

}
