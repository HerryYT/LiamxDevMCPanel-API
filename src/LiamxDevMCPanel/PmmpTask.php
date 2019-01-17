<?php

/*
 * LiamxDevMCPanel-API v5.0.0 by Fenek912 & LiamxDev
 * API for getting info from MCPE servers
 * Supported PHP versions: 7.0.x, 7.2.x
 * https://github.com/Fenek912/LiamxDevMCPanel-API
*/

namespace LiamxDevMCPanel;

use pocketmine\scheduler\Task;

class PmmpTask extends Task {

    public function __construct($plugin) {
        $this->plugin = $plugin;
    }

    public function onRun($currentTick) {
        $this->plugin->updateJson();
    }

}
