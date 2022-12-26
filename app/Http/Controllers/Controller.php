<?php

namespace App\Http\Controllers;

use App\Code\BBCode;
use App\Models\MinecraftVersion;
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

}
