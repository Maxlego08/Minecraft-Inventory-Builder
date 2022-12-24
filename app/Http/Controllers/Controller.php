<?php

namespace App\Http\Controllers;

use App\Code\BBCode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Stevebauman\Purify\Facades\Purify;

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
}
