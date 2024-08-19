<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder\Item;
use App\Models\MinecraftVersion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ItemController extends Controller
{
    public function updateItems(): RedirectResponse
    {

        $path = storage_path() . '/app/rendered.json';
        $json = json_decode(file_get_contents($path), true);

        foreach ($json as $value) {
            $item = Item::where('css', $value['css'])->first();
            if (isset($item)) {
                $version = MinecraftVersion::where('minecraft_version', $value['item']['version'] ?? 1.08)->first();
                $item->update([
                    'version_id' => $version?->id ?? 1,
                    'minecraft_id' => $value['item']['id'] ?? null,
                    'name' => $value['name'],
                    'data' => $value['item']['data'] ?? 0,
                    'material' => $value['item']['material'],
                    'old_material' => $value['item']['oldMaterial'] ?? null,
                    'max_stack_size' => $value['item']['max'] ?? 64,
                ]);

            } else {

                $version = MinecraftVersion::where('minecraft_version', $value['item']['version'] ?? 1.08)->first();
                Item::create([
                    'version_id' => $version?->id ?? 1,
                    'minecraft_id' => $value['item']['id'] ?? null,
                    'name' => $value['name'],
                    'data' => $value['item']['data'] ?? 0,
                    'css' => $value['css'],
                    'material' => $value['item']['material'],
                    'old_material' => $value['item']['oldMaterial'] ?? null,
                    'max_stack_size' => $value['item']['max'] ?? 64,
                ]);
            }
        }


        return Redirect::route('admin.index')->with('toast', createToast('success', 'Update of the items', 'You have just updated the items'));
    }

    public function updateJson()
    {

        $pathRendered = storage_path() . '/app/rendered.json';
        $pathItems = storage_path() . '/app/items.json';
        $rendered = json_decode(file_get_contents($pathRendered), true);
        $items = json_decode(file_get_contents($pathItems), true);

        foreach ($rendered as $key => $value) {
            $result = $this->findValueByKey($items, $value['name']);
            if (isset($result) && isset($result['stackSize'])) {
                $rendered[$key]['item']['max'] = $result['stackSize'];
            }
        }

        file_put_contents($pathRendered, json_encode($rendered, JSON_PRETTY_PRINT));
    }

    private function findValueByKey(array $values, string $key): ?array
    {
        foreach ($values as $value) {
            if ($value['newID'] == $key) return $value;
        }

        return null;
    }

}
