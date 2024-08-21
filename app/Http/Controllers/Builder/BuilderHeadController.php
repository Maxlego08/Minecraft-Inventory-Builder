<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Builder\Head;
use Illuminate\Support\Facades\Cache;

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
        // Clé de cache unique pour cette requête de recherche spécifique
        $cacheKey = 'search_heads_' . md5($search);

        // Vérifie si les résultats existent déjà dans le cache
        $heads = Cache::remember($cacheKey, 60 * 60 * 24, function () use ($search) { // Cache pour 1 jour
            return Head::where('name', 'like', "%{$search}%")
                ->orWhere('head_url', 'like', "%{$search}%")
                ->limit(150)
                ->get(['id', 'head_url', 'name', 'image_name', 'url_id']);
        });

        return json_encode($heads);
    }

}
