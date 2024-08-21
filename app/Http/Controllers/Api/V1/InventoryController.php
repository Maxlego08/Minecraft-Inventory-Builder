<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Builder\BuilderDownloadController;
use App\Http\Controllers\Controller;
use App\Models\Builder\Inventory;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InventoryController extends Controller
{

    /**
     * Returns list of folders and inventories
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function inventories(Request $request): JsonResponse
    {

        $user = $request->user();
        userLogOffline($user->id, "Vient de récupérer la liste des inventaires", UserLog::COLOR_SUCCESS, UserLog::ICON_DOWNLOAD, UserLog::TYPE_PLUGIN);

        $folders = $user->folders()->with('inventories')->get();

        return response()->json([
            'status' => true,
            'folders' => $folders,
        ]);
    }

    /**
     * Download inventory file
     *
     * @param Request $request
     * @param Inventory $inventory
     * @return \Illuminate\Foundation\Application|Response|JsonResponse|Application|ResponseFactory
     */
    public function download(Request $request, Inventory $inventory): \Illuminate\Foundation\Application|Response|JsonResponse|Application|ResponseFactory
    {

        $user = $request->user();
        userLogOffline($user->id, "Vient de télécharger l'inventaire $inventory->file_name.$inventory->id", UserLog::COLOR_SUCCESS, UserLog::ICON_DOWNLOAD, UserLog::TYPE_PLUGIN);

        if ($inventory->user_id !== $user->id) {
            return response()->json([
                'status' => false,
                'folders' => "You don't have the permission",
            ]);
        }

        $ymlContent = BuilderDownloadController::inventoryToYAML($inventory);

        return response($ymlContent, 200)
            ->header('Content-Type', 'text/yaml')
            ->header("Content-Disposition", "attachment; filename={$inventory->file_name}.yml");
    }
}
