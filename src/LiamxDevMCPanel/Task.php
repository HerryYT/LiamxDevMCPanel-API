<?php

namespace LiamxDevMCPanel;

use pocketmine\scheduler\PluginTask;

class Task extends PluginTask {

    public function __construct($plugin) {

        parent::__construct($plugin);

        $this->plugin = $plugin;

    }

    public function onRun($currentTick) {
        $playersArray = array();
        foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $playerName = $player->getName();
            array_push($playersArray, $playerName);
        }
        $jsonData = json_encode($playersArray);
        file_put_contents("data.json", $jsonData);
    }

}
