<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Builder\Folder;
use App\Models\UserLog;
use App\Models\UserRole;
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

    public function delete(Folder $folder): bool|string
    {

        $user = user();
        if ($folder->user_id != $user->id && !$user->isAdmin()){
            return json_encode([
                'result' => 'error',
                'toast' => createToast('error', 'Error', 'Cannot delete the folder.', 5000)
            ]);
        }

        $folder->delete();
        userLog("Vient de supprimer le dossier $folder->id", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);

        return json_encode([
            'result' => 'success',
            'toast' => createToast('success', 'Success', 'Folder as been deleted.', 5000)
        ]);
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'folderName' => 'required|regex:/^[a-zA-Z0-9 ]{3,30}$/'
        ]);

        $folder = new Folder();
        $folder->name = $validatedData['folderName'];
        $folder->save();

        return response()->json(['success' => 'Dossier créé avec succès.']);
    }

}
