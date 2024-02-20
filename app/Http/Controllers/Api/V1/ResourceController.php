<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Resource\Resource;
use App\Models\UserLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ResourceController extends Controller
{
    /**
     * Retrieves the list of resources
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resources(Request $request): JsonResponse
    {

        $user = $request->user();
        userLogOffline($user->id, "Vient de récupérer la liste des resources", UserLog::COLOR_SUCCESS, UserLog::ICON_DOWNLOAD, UserLog::TYPE_PLUGIN);

        $resources = Cache::remember("sanctum::resources", 900, function () {
            return Resource::where('is_display', true)->where('is_pending', false)->where('is_deleted', false)->get()->map(function ($resource) {
                return [
                    'id' => $resource->id,
                    'name' => $resource->name,
                    'user' => [
                        'id' => $resource->user_id,
                        'name' => $resource->user->name,
                    ],
                    'version' => $resource->version->version,
                    'category' => $resource->category->name,
                    'price' => $resource->price,
                    'currency' => $resource->user->paymentInfo?->currency?->icon ?? '€',
                    'tag' => $resource->tag,
                    'download' => $resource->countDownload(),
                    'link' => $resource->link('description'),
                ];
            });
        });

        return response()->json([
            'status' => true,
            'resources' => $resources,
        ]);
    }
}
