<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreviewController extends Controller
{
    /**
     * Permet de faire le rendu d'un bbcode
     *
     * @param Request $request
     * @return string
     */
    public function preview(Request $request): string
    {
        return $this->bbcode($request['bbcode'] ?? 'Error, empty bbcode');
    }
}
