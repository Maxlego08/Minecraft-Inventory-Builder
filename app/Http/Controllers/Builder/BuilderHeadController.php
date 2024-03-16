<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Builder\Head;

class BuilderHeadController extends Controller
{
    /**
     * Search heads
     *
     * @param $search
     * @return bool|string
     */
    public function search($search): bool|string
    {
        $heads = Head::where('name', 'like', "%$search%")->orWhere('head_url', 'like', "%$search%")->limit(150)->get(['id', 'head_url', 'name', 'image_name', 'url_id']);
        return json_encode($heads);
    }
}
