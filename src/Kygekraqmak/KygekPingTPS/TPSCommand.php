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

use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

class TPSCommand extends Command {
	
	/** @var Main $plugin */
	protected $plugin;

	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
		parent::__construct("tps", "Current tps of a player", "");
		$this->setPermission("kygektpstps.tps");
	}

	private function getConfig() : Config {
	    return $this->plugin->getConfig();
    }
	
	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			$sender->sendMessage(Main::replace($this->getConfig()->get("no-permission", "")));
			return false;
		}
		
		$tps = $this->plugin->getServer()->getTicksPerSecond();
		$sender->sendMessage(Main::replace($this->getConfig()->get("server-tps", ""), 
			[
				"{tps}" => $tps
			]
		));
		return true;
	}
}