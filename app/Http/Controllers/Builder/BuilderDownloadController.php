<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Builder\Inventory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Symfony\Component\Yaml\Yaml;

class BuilderDownloadController extends Controller
{

    /**
     * Permet de télécharger un fichier de configuration
     *
     * @param Inventory $inventory
     * @return \Illuminate\Foundation\Application|Response|Application|ResponseFactory
     */
    public function download(Inventory $inventory): \Illuminate\Foundation\Application|Response|Application|ResponseFactory
    {
        $user = user();
        if ($inventory->user_id != $user->id && !$user->isAdmin()) {
            abort(403, "You don't have permission");
        }

        $items = [];

        foreach ($inventory->buttons as $key => $button) {
            $buttonKey = $button->name;
            $items[$buttonKey] = [
                'slot' => (int)$button->slot,
                'item' => [
                    'material' => $button->item->material,
                    'amount' => $button->amount,
                ]
            ];

            if (isset($button->display_name) && $button->display_name !== null) {
                $items[$buttonKey]['item']['name'] = $button->display_name;
            }

            if (isset($button->lore) && $button->lore !== null) {
                $items[$buttonKey]['item']['lore'] = $button->lore;
            }
        }

        $data = [
            'name' => $inventory->name,
            'size' => $inventory->size,
            'items' => $items,
        ];

        $ymlContent = Yaml::dump($data, 4, 2, Yaml::DUMP_OBJECT_AS_MAP | Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);

        return response($ymlContent, 200)
            ->header('Content-Type', 'text/yaml')
            ->header("Content-Disposition", "attachment; filename={$inventory->file_name}.yml");

    }
}
