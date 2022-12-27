<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Resource;

class ResourceIndexController extends Controller
{
    public function index()
    {

        $pagination = Resource::paginate();
        return view('resources.index', [
            'resources' => $pagination,
            'categories' => $this->categories(),
        ]);
    }
}
