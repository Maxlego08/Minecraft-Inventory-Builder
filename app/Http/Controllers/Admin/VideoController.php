<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('created_at', 'DESC')->paginate();
        return view('admins.videos.index', [
            'videos' => $videos,
        ]);


    }

    //
    public function create()
    {
        return view('admins.videos.create');
    }


    public function store(Request $request): RedirectResponse
    {
        // Valider les données du formulaire
        $this->validate($request, [
            'url' => ['required', 'string', 'unique:videos,url'],
        ]);
        Video::create ([
            'url'=> $request->input('url'),
        ]);
        return Redirect::route("admin.videos.index");
    }
    public function delete(Video  $video): RedirectResponse
    {
        $video->delete();
        return Redirect::route("admin.videos.index");
    }
}
