<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;

class FileController extends Controller
{

    private $names = [
        "LEATHER_HELMET" => "<span style=\"color: #9f653f\">Casque en cuir</span>",
        "LEATHER_CHESTPLATE" => "<span style=\"color: #9f653f\">Plastron en cuir</span>",
        "LEATHER_LEGGINGS" => "<span style=\"color: #9f653f\">Pantalon en cuir</span>",
        "LEATHER_BOOTS" => "<span style=\"color: #9f653f\">Bottes en cuir</span>",
        "IRON_HELMET" => "<span style=\"color: #93c47d\">Casque en fer</span>",
        "IRON_CHESTPLATE" => "<span style=\"color: #93c47d\">Plastron en fer</span>",
        "IRON_LEGGINGS" => "<span style=\"color: #93c47d\">Pantalon en fer</span>",
        "IRON_BOOTS" => "<span style=\"color: #93c47d\">Bottes en fer</span>",
        "DIAMOND_HELMET" => "<span style=\"color: #6d9eeb\">Casque en diamant</span>",
        "DIAMOND_CHESTPLATE" => "<span style=\"color: #6d9eeb\">Plastron en diamant</span>",
        "DIAMOND_LEGGINGS" => "<span style=\"color: #6d9eeb\">Pantalon en diamant</span>",
        "DIAMOND_BOOTS" => "<span style=\"color: #6d9eeb\">Bottes en diamant</span>",
        "NETHERITE_HELMET" => "<span style=\"color: #c774ff\">Casque en netherite</span>",
        "NETHERITE_CHESTPLATE" => "<span style=\"color: #c774ff\">Plastron en netherite</span>",
        "NETHERITE_LEGGINGS" => "<span style=\"color: #c774ff\">Pantalon en netherite</span>",
        "NETHERITE_BOOTS" => "<span style=\"color: #c774ff\">Bottes en netherite</span>",
        "AXOLIUM_HELMET" => "<span style=\"color: #e9a154\">Casque en Axolium</span>",
        "AXOLIUM_CHESTPLATE" => "<span style=\"color: #e9a154\">Plastron en Axolium</span>",
        "AXOLIUM_LEGGINGS" => "<span style=\"color: #e9a154\">Pantalon en Axolium</span>",
        "AXOLIUM_BOOTS" => "<span style=\"color: #e9a154\">Bottes en Axolium</span>",
        "STONE_SWORD" => "<span style=\"color: #ffffff\">Épée en pierre</span>",
        "IRON_SWORD" => "<span style=\"color: #93c47d\">Épée en fer</span>",
        "DIAMOND_SWORD" => "<span style=\"color: #6d9eeb\">Épée en diamant</span>",
        "NETHERITE_SWORD" => "<span style=\"color: #c774ff\">Épée en netherite</span>",
        "AXOLIUM_SWORD" => "<span style=\"color: #e9a154\">Épée en Axolium</span>",
        "STONE_AXE" => "<span style=\"color: #ffffff\">Hache en pierre</span>",
        "IRON_AXE" => "<span style=\"color: #93c47d\">Hache en fer</span>",
        "DIAMOND_AXE" => "<span style=\"color: #6d9eeb\">Hache en diamant</span>",
        "NETHERITE_AXE" => "<span style=\"color: #c774ff\">Hache en netherite</span>",
        "AXOLIUM_AXE" => "<span style=\"color: #e9a154\">Hache en Axolium</span>",
        "BOW" => "<span style=\"color: #ffffff\">Arc</span>",
        "BOW_REINFORCED" => "<span style=\"color: #ffffff\">Arc renforcé</span>",
        "BOW_BEAST" => "<span style=\"color: #ffffff\">Arc de la bête</span>",
        "BOW_AXOLIUM" => "<span style=\"color: #ffffff\">Arc en Axolium</span>",
        "BASEBALL_BAT" => "<span style=\"color: #6d9eeb\">Batte de baseball</span>",
        "SNOW_CANON" => "<span style=\"color: #ffffff\">Canon à neige</span>",
        "AXOCOLA" => "<span style=\"color: #ffffff\">AxoCola</span>",
        "DONUTS" => "<span style=\"color: #93c47d\">Donuts</span>",
        "LIGHTED_BERRY" => "<span style=\"color: #ffef2d\">Baies luisantes</span>",
        "BURGER" => "<span style=\"color: #a29155\">Burger</span>",
        "GOLDEN_APPLE" => "<span style=\"color: #ffef2d\">Pomme d'Or</span>",
        "POTION_GOLD" => "<span style=\"color: #ffef2d\">Potion d'Or</span>",
        "POTION_SPEED" => "<span style=\"color: #c774ff\">Potion de Vitesse</span>",
        "CORRUPTED_AXEL" => "<span style=\"color: #a294ff\">Fragment d'Axel corrompu</span>",
        "ARROW" => "<span style=\"color: #ffffff\">Flèche</span>",
        "BLOCK" => "<span style=\"color: #6d9eeb\">Clay</span>",
        "WATER_BUCKET" => "<span style=\"color: #6d9eeb\">Seau d'eau</span>",
        "ENDER_PEARL" => "<span style=\"color: #c774ff\">Perle de l'Ender</span>",
        "ELYTRA_BOOSTER" => "<span style=\"color: #c774ff\">Elytra Booster</span>",
        "AMELIORATOR" => "<span style=\"color: #e9a154\">Améliorator</span>",
        "DISCO_BOMBE" => "<span style=\"color: #42d4f5\">Bombe disco</span>",
        "SMOKE_BOMBE" => "<span style=\"color: #989ea3\">Bombe fumigène</span>",
        "GRAPPLING_HOOK" => "<span style=\"color: #57d463\">Grappin</span>",
        "VIAL_OF_LIFE" => "<span style=\"color: #57d463\">Fiole de vie</span>",
        "INCENDIARY_MUTTON" => "<span style=\"color: #57d463\">Mouton incendiaire</span>",
        "XRAY_POTION" => "<span style=\"color: #2aeb84\">Potion de xray</span>",
        "SHADOW_STONE" => "<span style=\"color: #0080fc\">Pierre de l'ombre</span>",
        "DESIRE_STONE" => "<span style=\"color: #fc1f1c\">Pierre enflammée</span>",
        "DEAD_STONE" => "<span style=\"color: #3b8e31\">Pierre des morts</span>",
        "ETERNAL_CHEST" => "<span style=\"color: #d2b037\">Coffre éternel</span>",
        "RESPAWN_PLAYER" => "<span style=\"color: #a7ca6d\">Mémoire de réapparition</span>",
        // ... et les autres éléments
    ];

    private $items = [
        "stone_sword" => ["COMMON", "WEAPON"],
        "iron_sword" => ["UNCOMMON", "WEAPON"],
        "diamond_sword" => ["RARE", "WEAPON"],
        "netherite_sword" => ["EPIC", "WEAPON"],
        "axolium_sword" => ["LEGENDARY", "WEAPON"],
        "stone_axe" => ["COMMON", "WEAPON"],
        "iron_axe" => ["UNCOMMON", "WEAPON"],
        "diamond_axe" => ["RARE", "WEAPON"],
        "netherite_axe" => ["EPIC", "WEAPON"],
        "axolium_axe" => ["LEGENDARY", "WEAPON"],
        "bow" => ["UNCOMMON", "WEAPON"],
        "bow_reinforced" => ["RARE", "WEAPON"],
        "bow_beast" => ["EPIC", "WEAPON"],
        "bow_axolium" => ["LEGENDARY", "WEAPON"],
        "baseball_bat" => ["RARE", "WEAPON"],
        "snow_canon" => ["UNCOMMON", "WEAPON"],
        "leather_helmet" => ["COMMON", "ARMOR"],
        "leather_chestplate" => ["COMMON", "ARMOR"],
        "leather_leggings" => ["COMMON", "ARMOR"],
        "leather_boots" => ["COMMON", "ARMOR"],
        "iron_helmet" => ["UNCOMMON", "ARMOR"],
        "iron_chestplate" => ["UNCOMMON", "ARMOR"],
        "iron_leggings" => ["UNCOMMON", "ARMOR"],
        "iron_boots" => ["UNCOMMON", "ARMOR"],
        "diamond_helmet" => ["RARE", "ARMOR"],
        "diamond_chestplate" => ["RARE", "ARMOR"],
        "diamond_leggings" => ["RARE", "ARMOR"],
        "diamond_boots" => ["RARE", "ARMOR"],
        "netherite_helmet" => ["EPIC", "ARMOR"],
        "netherite_chestplate" => ["EPIC", "ARMOR"],
        "netherite_leggings" => ["EPIC", "ARMOR"],
        "netherite_boots" => ["EPIC", "ARMOR"],
        "axolium_helmet" => ["LEGENDARY", "ARMOR"],
        "axolium_chestplate" => ["LEGENDARY", "ARMOR"],
        "axolium_leggings" => ["LEGENDARY", "ARMOR"],
        "axolium_boots" => ["LEGENDARY", "ARMOR"],
        "axocola" => ["COMMON", "FOOD"],
        "donuts" => ["UNCOMMON", "FOOD"],
        "lighted_berry" => ["UNCOMMON", "FOOD"],
        "burger" => ["RARE", "FOOD"],
        "golden_apple" => ["RARE", "FOOD"],
        "potion_gold" => ["EPIC", "FOOD"],
        "potion_speed" => ["EPIC", "FOOD"],
        "corrupted_axel" => ["LEGENDARY", "FOOD"],
        "arrow" => ["COMMON", "OTHER"],
        "block" => ["UNCOMMON", "OTHER"],
        "water_bucket" => ["RARE", "OTHER"],
        "ender_pearl" => ["EPIC", "OTHER"],
        "elytra_booster" => ["LEGENDARY", "OTHER"],
        "ameliorator" => ["LEGENDARY", "OTHER"],
        "disco_bombe" => ["RARE", "OTHER"],
        "smoke_bombe" => ["RARE", "OTHER"],
        "grappling_hook" => ["EPIC", "OTHER"],
        "vial_of_life" => ["LEGENDARY", "OTHER"],
        "incendiary_mutton" => ["LEGENDARY", "OTHER"],
        "xray_potion" => ["RARE", "OTHER"],
        "shadow_stone" => ["UNIQUE", "OTHER"],
        "desire_stone" => ["UNIQUE", "OTHER"],
        "dead_stone" => ["UNIQUE", "OTHER"],
    ];

    /**
     * Afficher la page d'analyse
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('api.analyse');
    }

    /**
     * @param Request $request
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function store(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $itemSums = [];
        $itemCounts = [];
        $itemValues = []; // Pour stocker les valeurs individuelles pour la médiane

        if ($request->hasfile('files')) {
            foreach ($request->file('files') as $file) {
                $data = Yaml::parse(file_get_contents($file));

                foreach ($data as $item => $count) {
                    $itemSums[$item] = ($itemSums[$item] ?? 0) + $count;
                    $itemCounts[$item] = ($itemCounts[$item] ?? 0) + 1;
                    $itemValues[$item][] = $count; // Ajout de la valeur pour calculer la médiane plus tard
                }
            }
        }

        $analysis = [];
        foreach ($itemSums as $item => $total) {
            $mean = $total / $itemCounts[$item];
            sort($itemValues[$item]); // Tri des valeurs pour calculer la médiane
            $midpoint = floor(count($itemValues[$item]) / 2);
            $median = (count($itemValues[$item]) % 2 !== 0) ?
                $itemValues[$item][$midpoint] :
                ($itemValues[$item][$midpoint - 1] + $itemValues[$item][$midpoint]) / 2;

            $analysis[$item] = ['total' => $total, 'mean' => $mean, 'median' => $median];
        }

        // Ajouter le min et le max au tableau d'analyse
        foreach ($analysis as $item => &$data) {
            $data['min'] = min($itemValues[$item]);
            $data['max'] = max($itemValues[$item]);
            $data['info'] = $this->items[$item];
            $data['name'] = $this->names[strtoupper($item)];
        }

        // Tri des éléments par total
        uasort($analysis, function ($a, $b) {
            return $b['total'] - $a['total'];
        });

        return view('api.analyse', [
            'analysis' => $analysis,
            'files' => count($request->file('files'))
        ]);
    }

}
