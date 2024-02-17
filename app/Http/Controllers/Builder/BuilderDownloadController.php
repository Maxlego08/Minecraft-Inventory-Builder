<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Builder\Inventory;
use App\Models\Builder\InventoryButton;
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
        $sameButtons = [];

        foreach ($inventory->buttons as $key => $button) {

            $slot = (int)$button->slot;

            if ($slot >= $inventory->size) continue;

            $buttonKey = $button->name;
            $currentButton = $this->buttonToArray($button, $slot);

            $result = $this->is_in($button, $sameButtons);
            if (!$result) {

                $sameButtons[] = $button;
                $items[$buttonKey] = $currentButton;

            } else {

                $currentKey = $result->name;

                unset($items[$currentKey]['slot']);
                if (!isset($items[$currentKey]['slots'])) {
                    $items[$currentKey]['slots'] = [(int)$result->slot];
                }
                $items[$currentKey]['slots'][] = $slot;
            }
        };

        foreach ($items as $key => $value) if (isset($value['slots'])) $items[$key]['slots'] = $this->groupSlots($value['slots']);

        $data = [
            'name' => $inventory->name,
            'size' => $inventory->size,
            'items' => $items,
        ];

        $ymlContent = Yaml::dump($data, 99, 2, Yaml::DUMP_OBJECT_AS_MAP | Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);

        return response($ymlContent, 200)
            ->header('Content-Type', 'text/yaml')
            ->header("Content-Disposition", "attachment; filename={$inventory->file_name}.yml");

    }

    /**
     * Permet de regrouper les slots qui se suivent pour réduire la configuration
     *
     * @param $tableau
     * @return array
     */
    function groupSlots($tableau): array
    {
        sort($tableau);

        $result = [];
        $debut = $tableau[0];
        $precedent = $debut;

        for ($i = 1; $i < count($tableau); $i++) {
            if ($tableau[$i] == $precedent + 1) {
                $precedent = $tableau[$i];
            } else {
                if ($debut == $precedent) {
                    $result[] = "$debut";
                } else {
                    $result[] = "$debut-$precedent";
                }
                $debut = $tableau[$i];
                $precedent = $debut;
            }
        }

        if ($debut == $precedent) {
            $result[] = "$debut";
        } else {
            $result[] = "$debut-$precedent";
        }

        return $result;
    }

    public function is_in(InventoryButton $button, array $array): ?InventoryButton
    {
        $toRemove = ['slot', 'created_at', 'updated_at', 'name', 'id'];
        $attributes = $button->getAttributes();
        foreach ($toRemove as $remove) unset($attributes[$remove]);

        foreach ($array as $value) {
            $currentAttributes = $value->getAttributes();
            foreach ($toRemove as $remove) unset($currentAttributes[$remove]);

            if ($attributes === $currentAttributes) return $value;
        }
        return null;
    }

    private function buttonToArray(InventoryButton $button, int $slot): array
    {
        $array = [
            'slot' => $slot,
            'item' => [
                'material' => $button->item->material,
            ]
        ];

        if ($button->amount != 1) $array['item']['amount'] = $button->amount;

        if (isset($button->display_name)) $array['item']['name'] = $button->display_name;

        if (isset($button->lore)) $array['item']['lore'] = explode("\n", $button->lore);

        if ($button->model_id != 0) $array['item']['modelId'] = $button->model_id;
        if ($button->glow) $array['item']['glow'] = true;
        if ($button->is_permanent) $array['isPermanent'] = true;
        if ($button->close_inventory) $array['closeInventory'] = true;
        if ($button->refresh_on_click) $array['refreshOnClick'] = true;
        if ($button->update_on_click) $array['updateOnClick'] = true;
        if ($button->update) $array['update'] = true;
        if (isset($button->sound)) $array['sound'] = $button->sound;
        if ($button->pitch != 1) $array['pitch'] = $button->pitch;
        if ($button->volume != 1) $array['volume'] = $button->volume;
        if (isset($button->messages)) $array['messages'] = explode("\n", $button->messages);
        if (isset($button->commands)) $array['commands'] = explode("\n", $button->commands);
        if (isset($button->console_commands)) $array['consoleCommands'] = explode("\n", $button->console_commands);

        return $array;
    }

}
