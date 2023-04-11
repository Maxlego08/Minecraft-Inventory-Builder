<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Category;
use App\Models\Resource\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResourceIndexController extends Controller
{
    public function index(Request $request)
    {

        // $pagination = Resource::paginate();
        $pagination = ResourcePagination::paginate($request);
        return view('resources.index', [
            'resources' => $pagination,
            'categories' => $this->categories(),
        ]);
    }
}
