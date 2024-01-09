<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Builder\Folder;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BuilderIndexController extends Controller
{
    /**
     * Afficher la page principale
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('builder.index');
    }

    /**
     * Retourne les dossiers de l'utilisateur
     *
     * @param string|null $folder
     * @return bool|string
     */
    public function folders(string $folder = null): bool|string
    {
        $user = user();
        $parentHierarchy = [];

        if ($folder) {
            $folders = Folder::whereNotNull('parent_id')->where('id', $folder)->where('user_id', $user->id)->with('children')->first();
            if ($folders) {
                $parentFolder = $folders->parent;
                $parentHierarchy = $folders->getBreadcrumbHierarchy();
            } else {
                // Permet de récupérer le dossier et ses enfants, doit uniquement avoir un seul dossier
                $folders = Folder::whereNull('parent_id')->where('user_id', $user->id)->with('children')->first();
                $parentFolder = null;
            }
        } else {
            // Permet de récupérer le dossier et ses enfants, doit uniquement avoir un seul dossier
            $folders = Folder::whereNull('parent_id')->where('user_id', $user->id)->with('children')->first();
            $parentFolder = null;
        }

        if (isset($folders)) {
            return json_encode([
                'result' => 'success',
                'content' => $folders,
                'parentFolder' => $parentFolder,
                'parentHierarchy' => $parentHierarchy
            ]);
        } else {
            return json_encode([
                'result' => 'error',
                'message' => "Folder $folder was not found"
            ]);
        }
    }

    /**
     * Supprimer un dossier
     *
     * @param Folder $folder
     * @return bool|string
     */
    public function delete(Folder $folder): bool|string
    {

        $user = user();
        if ($folder->user_id != $user->id && !$user->isAdmin()) {
            return json_encode([
                'result' => 'error',
                'toast' => createToast('error', 'Error', 'Cannot delete the folder.', 5000)
            ]);
        }

        $folder->delete();
        userLog("Vient de supprimer le dossier $folder->name.$folder->id", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);

        return json_encode([
            'result' => 'success',
            'toast' => createToast('success', 'Success', 'Folder as been deleted.', 5000)
        ]);
    }

    /**
     * Permet de créer un dossier
     *
     * @param Request $request
     * @param Folder $folderParent
     * @return bool|string
     */
    public function create(Request $request, Folder $folderParent): bool|string
    {
        $validatedData = $request->validate([
            'folderName' => 'required|regex:/^[a-zA-Z0-9 ]{3,30}$/',
        ]);

        $user = user();
        if ($folderParent->user_id != $user->id) {
            return json_encode([
                'result' => 'error',
                'toast' => createToast('error', 'Error', 'Cannot create folder, please try again', 5000)
            ]);
        }

        $folder = Folder::create([
            'name' => $validatedData['folderName'],
            'user_id' => $user->id,
            'parent_id' => $folderParent->id,
        ]);

        userLog("Vient de créer le dossier $folder->name.$folder->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        return json_encode([
            'result' => 'success',
            'folder' => $folder,
            'toast' => createToast('success', 'Success', 'You have just created a folder', 5000)
        ]);
    }

}
