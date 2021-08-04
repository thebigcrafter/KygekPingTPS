<?php

/**
 *     _    __                  _                                     _
 *    | |  / /                 | |                                   | |
 *    | | / /                  | |                                   | |
 *    | |/ / _   _  ____   ____| | ______ ____   _____ ______   ____ | | __
 *    | |\ \| | | |/ __ \ / __ \ |/ /  __/ __ \ / __  | _  _ \ / __ \| |/ /
 *    | | \ \ \_| | <__> |  ___/   <| / | <__> | <__| | |\ |\ | <__> |   <
 * By |_|  \_\__  |\___  |\____|_|\_\_|  \____^_\___  |_||_||_|\____^_\|\_\
 *              | |    | |                          | |
 *           ___/ | ___/ |                          | |
 *          |____/ |____/                           |_|
 *
 * A PocketMine-MP plugin to see the server TPS and a player's ping
 * Copyright (C) 2020-2021 Kygekraqmak
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
*/

declare(strict_types=1);

namespace Kygekraqmak\KygekPingTPS;

use pocketmine\utils\Config;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat as TF;

class TPS {

	public $tps;

    private function getConfig() : Config {
        return Main::getInstance()->getConfig();
    }

	public function TPSCommand(CommandSender $sender, Command $cmd, string $label, array $args) {
		$this->tps = Main::getInstance()->getServer()->getTicksPerSecond();
		if ($sender->hasPermission("kygekpingtps.tps")) $sender->sendMessage($this->getServerTPSMessage());
		else $sender->sendMessage($this->getNoPermMessage());
	}

    private function getNoPermMessage() : string {
        $noperm = $this->getConfig()->get("no-permission", "");
        $noperm = Main::replace($noperm);
        return empty($noperm) ? Main::PREFIX . TF::RED . "You do not have permission to use this command" : $noperm;
    }

    private function getServerTPSMessage() : string {
        $servertps = $this->getConfig()->get("server-tps", "");
        $servertps = str_replace("{tps}", (string) $this->tps, Main::replace($servertps));
        return empty($servertps) ? Main::PREFIX . TF::GREEN . "Current server TPS: " . TF::AQUA . $this->tps : $servertps;
    }

}
