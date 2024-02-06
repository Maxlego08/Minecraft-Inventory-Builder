<?php

namespace App\Http\Controllers;

class ExportDataController extends Controller
{

    private $elements = '<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-acacia-hanging-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Acacia Hanging Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-angler-pottery-sherd"></span><span>Angler Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-archer-pottery-sherd"></span><span>Archer Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-arms-up-pottery-sherd"></span><span>Arms Up Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-block"></span><span>Bamboo Block</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-button"></span><span>Bamboo Button</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-chest-raft"></span><span>Bamboo Chest Raft</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-door"></span><span>Bamboo Door</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-fence"></span><span>Bamboo Fence</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-fence-gate"></span><span>Bamboo Fence Gate</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-hanging-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Bamboo Hanging Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-mosaic"></span><span>Bamboo Mosaic</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-mosaic-slab"></span><span>Bamboo Mosaic Slab</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-mosaic-stairs"></span><span>Bamboo Mosaic Stairs</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-planks"></span><span>Bamboo Planks</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-pressure-plate"></span><span>Bamboo Pressure Plate</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-raft"></span><span>Bamboo Raft</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Bamboo Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-slab"></span><span>Bamboo Slab</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-stairs"></span><span>Bamboo Stairs</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-bamboo-trapdoor"></span><span>Bamboo Trapdoor</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-birch-hanging-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Birch Hanging Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-blade-pottery-sherd"></span><span>Blade Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-brewer-pottery-sherd"></span><span>Brewer Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-brush"></span><span>Brush</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-burn-pottery-sherd"></span><span>Burn Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-calibrated-sculk-sensor"></span><span>Calibrated Sculk Sensor</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-spawn-egg-camel"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/mob-generator/summon-camel">Camel Spawn Egg</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-boat"></span><span>Cherry Boat</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-button"></span><span>Cherry Button</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-chest-boat"></span><span>Cherry Chest Boat</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-door"></span><span>Cherry Door</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-fence"></span><span>Cherry Fence</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-fence-gate"></span><span>Cherry Fence Gate</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-hanging-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Cherry Hanging Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-leaves"></span><span>Cherry Leaves</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-log"></span><span>Cherry Log</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-planks"></span><span>Cherry Planks</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-pressure-plate"></span><span>Cherry Pressure Plate</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-sapling"></span><span>Cherry Sapling</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Cherry Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-slab"></span><span>Cherry Slab</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-stairs"></span><span>Cherry Stairs</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-trapdoor"></span><span>Cherry Trapdoor</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-cherry-wood"></span><span>Cherry Wood</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-chiseled-bookshelf"></span><span>Chiseled Bookshelf</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-coast-armor-trim-smithing-template"></span><span>Coast Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-crimson-hanging-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Crimson Hanging Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-danger-pottery-sherd"></span><span>Danger Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-dark-oak-hanging-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Dark Oak Hanging Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-decorated-pot"></span><span>Decorated Pot</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-dune-armor-trim-smithing-template"></span><span>Dune Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-spawn-egg-ender-dragon"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/mob-generator/summon-ender_dragon">Ender Dragon Spawn Egg</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-explorer-pottery-sherd"></span><span>Explorer Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-eye-armor-trim-smithing-template"></span><span>Eye Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-friend-pottery-sherd"></span><span>Friend Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-heart-pottery-sherd"></span><span>Heart Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-heartbreak-pottery-sherd"></span><span>Heartbreak Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-host-armor-trim-smithing-template"></span><span>Host Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-howl-pottery-sherd"></span><span>Howl Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-spawn-egg-iron-golem"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/mob-generator/summon-iron_golem">Iron Golem Spawn Egg</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-jungle-hanging-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Jungle Hanging Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-mangrove-hanging-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Mangrove Hanging Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-miner-pottery-sherd"></span><span>Miner Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-mourner-pottery-sherd"></span><span>Mourner Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-music-disc-relic"></span><span>Music Disc Relic</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-netherite-upgrade-smithing-template"></span><span>Netherite Upgrade Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-oak-hanging-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Oak Hanging Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-piglin-head"></span><span>Piglin Head</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-pink-petals"></span><span>Pink Petals</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-pitcher-plant"></span><span>Pitcher Plant</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-pitcher-pod"></span><span>Pitcher Pod</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-plenty-pottery-sherd"></span><span>Plenty Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-prize-pottery-sherd"></span><span>Prize Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-raiser-armor-trim-smithing-template"></span><span>Raiser Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-rib-armor-trim-smithing-template"></span><span>Rib Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-sentry-armor-trim-smithing-template"></span><span>Sentry Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-shaper-armor-trim-smithing-template"></span><span>Shaper Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-sheaf-pottery-sherd"></span><span>Sheaf Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-shelter-pottery-sherd"></span><span>Shelter Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-silence-armor-trim-smithing-template"></span><span>Silence Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-skull-pottery-sherd"></span><span>Skull Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-sniffer-egg"></span><span>Sniffer Egg</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-spawn-egg-sniffer"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/mob-generator#sniffer">Sniffer Spawn Egg</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-snort-pottery-sherd"></span><span>Snort Pottery Sherd</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-snout-armor-trim-smithing-template"></span><span>Snout Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-spawn-egg-snow-golem"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/mob-generator/summon-snow_golem">Snow Golem Spawn Egg</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-spire-armor-trim-smithing-template"></span><span>Spire Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-spruce-hanging-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Spruce Hanging Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-stripped-bamboo-block"></span><span>Stripped Bamboo Block</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-stripped-cherry-log"></span><span>Stripped Cherry Log</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-stripped-cherry-wood"></span><span>Stripped Cherry Wood</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-suspicious-gravel"></span><span>Suspicious Gravel</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-suspicious-sand"></span><span>Suspicious Sand</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-tide-armor-trim-smithing-template"></span><span>Tide Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-torchflower"></span><span>Torchflower</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-torchflower-seeds"></span><span>Torchflower Seeds</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-vex-armor-trim-smithing-template"></span><span>Vex Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-ward-armor-trim-smithing-template"></span><span>Ward Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-warped-hanging-sign"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/give-command-generator/signs">Warped Hanging Sign</a></span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-wayfinder-armor-trim-smithing-template"></span><span>Wayfinder Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-wild-armor-trim-smithing-template"></span><span>Wild Armor Trim Smithing Template</span></div>
	<div class="col-xs-12 col-sm-6 col-lg-4 list-of-item"><span class="icon-minecraft icon-minecraft-spawn-egg-wither"></span><span><a href="https://www.gamergeeks.net/apps/minecraft/mob-generator/summon-wither">Wither Spawn Egg</a></span></div>';


    public function index()
    {

        $pattern = '/icon-minecraft-([a-z0-9-]+)/';

        $currentNames = [];

        if (preg_match_all($pattern, $this->elements, $matches)) {
            // $matches[1] contient toutes les parties capturées par les parenthèses dans le regex
            foreach ($matches[1] as $match) {

                $match = str_replace("-", "_", $match);

                // Affichage de chaque correspondance
                $currentNames[$match] = [
                    "material" => strtoupper($match),
                    "version" => 1.20
                ];
            }
        } else {
            echo "Aucune correspondance trouvée.";
        }

        dd(json_encode($currentNames, JSON_PRETTY_PRINT));
        return json_encode($currentNames, JSON_PRETTY_PRINT);
    }
}
