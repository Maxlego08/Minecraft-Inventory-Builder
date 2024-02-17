<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder\Folder;
use App\Models\Builder\Inventory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Page principale des inventaires
     *
     * @param Request $request
     * @return Factory|\Illuminate\Foundation\Application|View|Application
     */
    public function index(Request $request): Factory|\Illuminate\Foundation\Application|View|Application
    {

        $search = $request->input('search');
        $inventories = Inventory::with('user')->with('folder')->select('inventories.*')
            ->when($search, function ($query, $search) {
                return $query->leftJoin('users', 'inventories.user_id', '=', 'users.id')
                    ->where(function ($query) use ($search) {
                        $query->where('inventories.file_name', 'like', "%{$search}%")
                            ->orWhere('inventories.name', 'like', "%{$search}%")
                            ->orWhere('users.name', 'like', "%{$search}%")
                            ->orWhere('users.email', 'like', "%{$search}%");
                    });
            })
            ->paginate();

        return view('admins.inventories.index', [
            'inventories' => $inventories,
            'search' => $search,
        ]);

    }

    /**
     * Affiche-les sous dossiers d'un utilisateur
     *
     * @param Folder $folder
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function folderUser(Folder $folder): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('admins.inventories.folders', [
            'folders' => $folder->children,
            'folder' => $folder,
            'inventories' => $folder->inventories,
        ]);

    }

    /**
     * Retourne la liste de tous les dossiers
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function folders(Request $request): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $search = $request->input('search');
        $folders = Folder::with('user')->select('folders.*')
            ->when($search, function ($query, $search) {
                return $query->leftJoin('users', 'folders.user_id', '=', 'users.id')
                    ->where(function ($query) use ($search) {
                        $query->where('folders.name', 'like', "%{$search}%")
                            ->orWhere('users.name', 'like', "%{$search}%")
                            ->orWhere('users.email', 'like', "%{$search}%");
                    });
            })->whereNull('parent_id')->latest()->paginate();
        return view('admins.inventories.folder_index', [
            'folders' => $folders,
            'search' => $search,
        ]);

    }

}
