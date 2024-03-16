<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Builder\Inventory;
use App\Models\Builder\InventoryButton;
use App\Models\UserLog;
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

        userLog("Vient de télécharger l'inventaire $inventory->file_name.$inventory->id", UserLog::COLOR_SUCCESS, UserLog::ICON_DOWNLOAD);

        $ymlContent = self::inventoryToYAML($inventory);

        return response($ymlContent, 200)
            ->header('Content-Type', 'text/yaml')
            ->header("Content-Disposition", "attachment; filename={$inventory->file_name}.yml");

    }

    /**
     * Inventory to YAML
     *
     * @param Inventory $inventory
     * @return string
     */
    public static function inventoryToYAML(Inventory $inventory): string
    {

        $items = [];
        $sameButtons = [];

        foreach ($inventory->buttons as $key => $button) {

            $slot = (int)$button->slot;

            if ($slot >= $inventory->size) continue;

            $buttonKey = $button->name;
            $currentButton = self::buttonToArray($button, $slot);

            $result = self::is_in($button, $sameButtons);
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

        foreach ($items as $key => $value) if (isset($value['slots'])) $items[$key]['slots'] = self::groupSlots($value['slots']);

        $data = [
            'name' => $inventory->name,
            'size' => $inventory->size,
            'items' => $items,
        ];

        return Yaml::dump($data, 99, 2, Yaml::DUMP_OBJECT_AS_MAP | Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    }

    private static function buttonToArray(InventoryButton $button, int $slot): array
    {
        $array = [
            'slot' => $slot,
            'item' => [
                'material' => $button->item->material,
            ]
        ];

        if ($button->head) {
            unset($array['item']['material']);
            $array['item']['url'] = $button->head->head_url;
        }

        if ($button->page != 1) $array['page'] = $button->page;
        if ($button->buttonType->id != 1) $array['type'] = strtoupper($button->buttonType->name);

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

        $data = json_decode($button->button_data ?? '{}', true);
        foreach ($button->buttonType->contents as $content) {
            $value = $data[$content->key] ?? '';
            switch ($content->data_type) {
                case 'number':
                {
                    if (filter_var($value, FILTER_VALIDATE_INT) !== false) {
                        $array[$content->key] = (int)$value;
                    } else $array[$content->key] = $value;
                    break;
                }
                case 'textarea':
                {
                    $array[$content->key] = explode("\n", $value);
                    break;
                }
                default:
                {
                    $array[$content->key] = $value;
                }
            }
        }

        return $array;
    }

    private static function is_in(InventoryButton $button, array $array): ?InventoryButton
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

    /**
     * Permet de regrouper les slots qui se suivent pour réduire la configuration
     *
     * @param $tableau
     * @return array
     */
    private static function groupSlots($tableau): array
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

}
