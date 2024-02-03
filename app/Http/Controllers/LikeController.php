<?php

namespace App\Http\Controllers;

use App\Models\Alert\AlertUser;
use App\Models\Resource\Resource;
use App\Models\Resource\Version;
use App\Models\User;
use App\Models\UserLog;
use App\Utils\Likeable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class LikeController extends Controller
{
    /**
     * Ajouter ou supprimer un like d'une resource
     *
     * @param Resource $resource
     * @return JsonResponse
     */
    public function toggleResourceLike(Resource $resource): JsonResponse
    {
        return $this->toggleLike($resource);
    }

    /**
     * Ajouter ou supprimer un like d'une version
     *
     * @param Version $version
     * @return JsonResponse
     */
    public function toggleVersionLike(Version $version): JsonResponse
    {
        return $this->toggleLike($version);
    }

    /**
     * Permet d'ajouter ou supprimer un like sur un model
     *
     * @param Likeable $likeable
     * @return JsonResponse
     */
    public function toggleLike(Likeable $likeable): JsonResponse
    {
        $user = user();
        if (!$user->canLike($likeable)) {
            return response()->json(['message' => "You can't like your own content"]);
        }

        $like = $likeable->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            $status = 'removed';
            userLog("Vient de supprimer un like à la {$likeable->getContentName()}", UserLog::COLOR_DANGER, UserLog::ICON_DISLIKE);
        } else {

            $likeable->likes()->create(['user_id' => $user->id]);
            $status = 'added';
            userLog("Vient d'ajouter un like à la {$likeable->getContentName()}", UserLog::COLOR_SUCCESS, UserLog::ICON_LIKE);
            $this->createNotification($likeable, $user);
        }

        Cache::forget("likes.{$likeable->getCacheName()}");
        Cache::forget("user_{$user->id}_{$likeable->getCacheName()}");
        $this->cancelAuthorCache($likeable);

        return response()->json([
            'message' => $status,
            'likes' => formatLikedBy($likeable)
        ]);
    }

    private function createNotification(Likeable $likeable, User $user)
    {
        if ($likeable instanceof Resource) {
            createUniqueAlert($likeable->user_id, $likeable->name, AlertUser::ICON_LIKE, AlertUser::SUCCESS, 'alerts.alerts.resources.like_resource', $likeable->link('description'), $user->id);
        }
        if ($likeable instanceof Version) {
            createUniqueAlert($likeable->resource->user_id, $likeable->title, AlertUser::ICON_LIKE, AlertUser::SUCCESS, 'alerts.alerts.resources.like_update', $likeable->resource->link('updates'), $user->id);
        }
    }

    private function cancelAuthorCache(Likeable $likeable)
    {
        $id = match (true) {
            $likeable instanceof Resource => $likeable->user_id,
            $likeable instanceof Version => $likeable->resource->user_id,
        };
        Cache::forget("likes.total::$id");
    }
}
