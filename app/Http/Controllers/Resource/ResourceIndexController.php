<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Category;
use App\Models\Resource\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ResourceIndexController extends Controller
{
    public function index(Request $request)
    {

        // $pagination = Resource::paginate();
        $pagination = ResourcePagination::paginate();
        // DB::enableQueryLog(); // Enable query log
        // dd(DB::getQueryLog()); // Show results of log

        $mostResources = Cache::remember('resources:mostResources', 300, function () {
            $mostResourcesUsers = ResourcePagination::mostResources();
            $mostResources = [];
            foreach ($mostResourcesUsers as $user) {
                $count = Resource::where('user_id', $user->id)->count();
                $mostResources[] = ['name' => $user->name, 'url' => $user->authorPage(), 'count' => $count, 'image' => $user->getProfilePhotoUrlAttribute(),];
            }
            return $mostResources;
        });

        return view('resources.index', ['resources' => $pagination, 'categories' => $this->categories(), 'mostResources' => $mostResources,]);
    }
}
