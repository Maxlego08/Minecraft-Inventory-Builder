<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourceIndexController extends Controller
{
    public function index(Request $request)
    {

        // $pagination = Resource::paginate();
        $pagination = ResourcePagination::paginate();
        // DB::enableQueryLog(); // Enable query log
        // dd(DB::getQueryLog()); // Show results of log

        $mostResources = ResourcePagination::mostResourcesPagination();
        return view('resources.index', ['resources' => $pagination, 'categories' => $this->categories(), 'mostResources' => $mostResources,]);
    }
}
