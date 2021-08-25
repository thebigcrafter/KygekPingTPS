<?php
/*
 * See your and others's ping and the server tps
 * Copyright © 2021 KygekTeam
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */
declare(strict_types=1);
namespace KygekTeam\KygekPingTPS;

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