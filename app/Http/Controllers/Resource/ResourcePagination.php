<?php

namespace App\Http\Controllers\Resource;

use App\Models\Resource\Category;
use App\Models\Resource\Resource;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResourcePagination
{

    public static function mostResources(){
        return User::select('users.name', 'users.id', 'users.profile_photo_path')
            ->addSelect(DB::raw("COUNT(`resource_resources`.`id`) AS `resource`"))
            ->join('resource_resources', 'resource_resources.user_id', '=', 'users.id')
            ->where('resource_resources.is_display', true)
            ->where('resource_resources.is_pending', false)
            ->groupBy('resource_resources.user_id')
            ->groupBy('users.id')
            ->groupBy('users.name')
            ->groupBy('users.profile_photo_path')
            ->orderBy('resource', 'DESC')
            ->limit(5)->get();
    }

    /**
     * Paginate resources
     *
     * @param Category|null $category
     * @return mixed
     */
    public static function paginate(Category $category = null): mixed
    {
        $search = request()->input('search');

        return Resource::select("resource_resources.*")
            ->with('version')
            ->with('category')
            ->with('icon')
            ->leftJoin('resource_versions', 'resource_resources.version_id', '=', 'resource_versions.id')
            ->leftJoin('users', 'users.id', '=', 'resource_resources.user_id')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('resource_resources.name', 'like', '%' . $search . '%');
                    $query->orWhere('resource_resources.tag', 'like', '%' . $search . '%');
                    $query->orWhere('users.name', 'like', '%' . $search . '%');
                });
            })
            ->when($category, function ($query) use ($category) {
                $query->where('resource_resources.category_id', $category->id);
            })
            ->when(!Auth::guest(), function ($query) {
                $user = Auth::user();
                $query->where('resource_resources.is_pending', true)->where('resource_resources.user_id', $user->id)
                    ->orWhere('resource_resources.is_pending', false);
            }, function ($query) {
                $query->where('resource_resources.is_pending', false);
            })
            ->where('resource_resources.is_display', true)
            ->orderBy('resource_versions.created_at', 'DESC')
            ->paginate();
    }

}
