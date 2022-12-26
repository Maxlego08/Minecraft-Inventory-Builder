<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ResourceCreateController extends Controller
{
    /**
     * Permet de créer une nouvelle resource
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('resources.create', [
            'versions' => $this->versions(),
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

}
