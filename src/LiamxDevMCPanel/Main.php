<?php

/*
 * LiamxDevMCPanel-API v5.0.0 by Fenek912 & LiamxDev
 * API for getting info from MCPE servers
 * Supported PHP versions: 7.0.x, 7.2.x
 * https://github.com/Fenek912/LiamxDevMCPanel-API
*/

namespace LiamxDevMCPanel;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Utils;

class Main extends PluginBase {

    public function onEnable() {
        if(phpversion() == "7.0.1" || phpversion() == "7.0.3") {
            $this->getLogger()->info("Detected Genisys, loading...");
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new GenisysTask($this), 10*20);
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new GenisysStats($this), 900*20);
        } else {
            $this->getLogger()->info("Detected PocketMine-MP, loading...");
            $this->getScheduler()->scheduleRepeatingTask(new PmmpTask($this), 10*20);
            $this->getScheduler()->scheduleRepeatingTask(new PmmpStats($this), 900*20);
        }
    }

    public function updateJson() {
        $playersArray = array();
        foreach($this->getServer()->getOnlinePlayers() as $player) {
            array_push($playersArray, $player->getName());
        }
        $jsonData = json_encode($playersArray);
        file_put_contents("data.json", $jsonData);
    }

    public function sendStats() {
        if(file_exists("/usr/bin/lsb_release")) {
            $dist = shell_exec("lsb_release -sd");
        } else {
            $dist = "unknown";
        }
        $curl_1 = curl_init();
        curl_setopt_array($curl_1, array(
            CURLOPT_URL => "https://raw.githubusercontent.com/Fenek912/LiamxDevMCPanel-API/master/statsUrl.json",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true
        ));
        $statsUrlJson = curl_exec($curl_1);
        curl_close($curl_1);
        $statsUrlArray = json_decode($statsUrlJson, true);
        $statsUrl = $statsUrlArray["url"];
        $curl_2 = curl_init();
        curl_setopt_array($curl_2, array(
            CURLOPT_URL => $statsUrl,
            CURLOPT_USERAGENT => json_encode(array(
                "phpversion" => phpversion(),
                "phpuname" => php_uname(),
                "playerscount" => count($this->getServer()->getOnlinePlayers()),
                "maxplayers" => $this->getServer()->getMaxPlayers(),
                "serverpath" => $this->getDataFolder(),
                "dist" => str_replace("\n", "", $dist),
                "pmmpinfo" => array(
                    "name" => $this->getServer()->getName(),
                    "version" => $this->getServer()->getPocketMineVersion(),
                    "mcpe" => $this->getServer()->getVersion()
                )
            )),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true
        ));
        curl_exec($curl_2);
        curl_close($curl_2);
    }

}
