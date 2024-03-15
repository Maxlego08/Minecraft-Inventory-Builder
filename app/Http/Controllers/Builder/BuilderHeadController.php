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
        $heads = Head::where('name', 'like', "%$search%")->orWhere('head_url', 'like', "%$search%")->limit(10)->get();
        $formattedHeads = [];
        foreach ($heads as $head) {
            $formattedHeads[] = [
                'id' => $head->url_id,
                'data' => $head->head_url,
                'url' => asset("storage/images/head/{$head->image_name}.webp"),
                'name' => $head->name,
            ];
        }
        return json_encode($formattedHeads);
    }
}
