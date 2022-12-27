<?php

namespace App\Http\Controllers;

use App\Code\BBCode;
use App\Models\MinecraftVersion;
use App\Models\Resource\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Permet de transformer le bbcode en html
     *
     * @param string $bbcode
     * @return string
     */
    protected function bbcode(string $bbcode): string
    {
        return BBCode::renderAndPurify($bbcode);
    }

    /**
     * Retourne les versions de minecraft
     *
     * @return mixed
     */
    protected function versions(): mixed
    {
        return Cache::remember('versions', 60 * 10, function () {
            return MinecraftVersion::orderBy('released_at')->get();
        });
    }

    /**
     * Permet d'avoir un cache sur les catégories
     * Le cache est par défaut de 24 heures, sauf si une action sur les resources est effectué, alors le cache sera oublié et calculer de nouveau
     *
     * @return mixed
     */
    protected function categories(): mixed
    {
        return Cache::remember('categories', 1, function () {

            $categories = Category::all(); // On va récupérer toutes les catégories
            $arrayCategories = []; // Tableau qui va contenir les categories

            foreach ($categories as $category) {
                $arrayCategories[$category->name] = [
                    'count' => $category->countResources(),
                    'sub' => $category->category_id == null,
                ];
            }

            return $arrayCategories;
        });
    }


    /**
     * Permet de supprimer le cache des catégories
     *
     * @return void
     */
    protected function destroyCacheCategories(): void
    {
        Cache::forget('categories');
    }

}
