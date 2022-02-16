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
 * Copyright (C) 2020-2021 Kygekraqmak, KygekTeam
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
*/

declare(strict_types=1);

namespace Kygekraqmak\KygekPingTPS;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class PingCommand extends Command {
	
	/** @var Main $plugin */
	protected $plugin;

	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
		parent::__construct("ping", "Current ping of a player", Main::replace($this->getConfig()->get("prefix") . TF::WHITE . "Usage: /ping <player>"));
		$this->setPermission("kygekpingtps.ping");
	}

	private function getConfig() : Config {
	    return $this->plugin->getConfig();
    }
	
	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			$sender->sendMessage(Main::replace($this->getConfig()->get("no-permission", "")));
			return false;
		}
		
		$target_name = implode(' ', $args);
		$target = $this->plugin->getServer()->getPlayerByPrefix($target_name);
		
		if (!empty($target_name)) {
			if (is_null($target)) {
				$sender->sendMessage(Main::replace($this->getConfig()->get("player-not-found", ""), 
					[
						"{player}" => $target_name
					]
				));
				return true;
			}
			
			if ($sender !== $target) {
				if ($sender->hasPermission("kygekpingtps.ping.others")) {
					$sender->sendMessage(Main::replace($this->getConfig()->get("other-ping", ""), 
						[
							"{ping}" => $target->getNetworkSession()->getPing(),
							"{player}" => $target->getName()
						]
					));
				} else
					$sender->sendMessage(Main::replace($this->getConfig()->get("no-other-ping-perm", "")));
				return true;
			}
		}
		
		if ($sender instanceof Player) {
			$sender->sendMessage(Main::replace($this->getConfig()->get("self-ping", ""), 
				[
					"{ping}" => $sender->getNetworkSession()->getPing()
				]
			));
		} else $sender->sendMessage($this->getUsage());
		return true;
	}
}