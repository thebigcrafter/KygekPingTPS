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

use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

class Ping {

	public $other;
	public $pingother;
	public $prefix;
	public $noperm;
	public $notfound;
	public $usage;

	public function PingCommand(CommandSender $sender, Command $cmd, string $label, array $args) {
		$this->prefix = TextFormat::YELLOW . "[KygekPingTPS] ";
		$this->noperm = $this->prefix . TextFormat::RED . "You do not have permission to use this command";
		$this->usage = $this->prefix . TextFormat::WHITE . "Usage: /ping <player>";
		if (isset($args[0])) {
			$this->other = Main::getInstance()->getServer()->getPlayerExact($args[0]);
			$this->notfound = $this->prefix . TextFormat::RED . "Player was not found";
			if ($this->other == null) {
				$sender->sendMessage($this->notfound);
				return;
			}
			$this->pingother = TextFormat::AQUA . $this->other->getPing();
		}
		if (!$sender instanceof Player) {
			if (count($args) < 1) $sender->sendMessage($this->usage);
			elseif (isset($args[0])) {
				if (!$this->other instanceof Player) $sender->sendMessage($this->notfound);
				else $sender->sendMessage($this->prefix . TextFormat::GREEN . $this->other->getName() . "'s current ping: " . $this->pingother);
			}
		} else {
			if ($sender->hasPermission("kygekpingtps.ping")) {
				if (count($args) < 1) $sender->sendMessage($this->prefix . TextFormat::GREEN . "Your current ping: " . TextFormat::AQUA . $sender->getPing());
				elseif (isset($args[0])) {
					if (!$this->other instanceof Player) $sender->sendMessage($this->notfound);
					else $sender->sendMessage($this->prefix . TextFormat::GREEN . $this->other->getName() . "'s current ping: " . $this->pingother);
				}
			} else $sender->sendMessage($this->noperm);
		}
	}

}
