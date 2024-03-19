<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Builder\Head;
use Illuminate\Support\Facades\Cache;

class HeadController extends Controller
{
    public function heads()
    {

        $values = Cache::remember("heads:json", 10, function (){

            $result = [];
            $heads = Head::whereNotNull('category')->get();

            foreach ($heads as $head){
                $result[] = [
                    "id" => $head->url_id,
                    "name" => $head->name,
                    "value" => $head->head_url,
                    "tags" => $head->tags,
                    "category" => $head->category,
                ];
            }

            return $result;
        });

        return response()->json($values);
    }
}
