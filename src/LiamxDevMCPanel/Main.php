<?php

namespace LiamxDevMCPanel;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    public function onEnable() {

        $this->getLogger()->info("Loading...");

        $this->getServer()->getScheduler()->scheduleRepeatingTask(new Task($this), 10*20);

    }

}
