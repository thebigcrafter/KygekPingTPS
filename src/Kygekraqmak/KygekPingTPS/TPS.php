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
 * Copyright (C) 2020 Kygekraqmak
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
*/

declare(strict_types=1);

namespace Kygekraqmak\KygekPingTPS;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use Kygekraqmak\KygekPingTPS\Main;

class TPS {

	public $tps;
	public $prefix;
	public $noperm;

	public function TPSCommand(CommandSender $sender, Command $cmd, string $label, array $args) {
		$this->tps = TextFormat::AQUA . Main::getInstance()->getServer()->getTicksPerSecond();
		$this->prefix = TextFormat::YELLOW . "[KygekPingTPS] ";
		$this->noperm = $this->prefix . TextFormat::RED . "You do not have permission to use this command";
		if ($sender->hasPermission("kygekpingtps.tps")) $sender->sendMessage($this->prefix . TextFormat::GREEN . "Current server TPS: " . $this->tps);
		else $sender->sendMessage($this->noperm);
	}

}
