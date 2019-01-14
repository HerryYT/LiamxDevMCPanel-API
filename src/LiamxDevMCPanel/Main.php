<?php

namespace LiamxDevMCPanel;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    public function onEnable() {
        if(file_exists("genisys.yml")) {
            $this->getLogger()->info("Loading API for Genisys");
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new GenisysTask($this), 10*20);
        } else {
            $this->getLogger()->info("Loading API for PMMP");
            $this->getScheduler()->scheduleRepeatingTask(new PmmpTask($this), 10*20);
        }
    }

}
