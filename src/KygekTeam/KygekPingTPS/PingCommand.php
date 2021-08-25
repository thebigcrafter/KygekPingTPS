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
		
		$target = $this->plugin->getServer()->getPlayer($args[0] ?? "");
		
		if (is_null($target) && isset($args[0])) {
			$sender->sendMessage(Main::replace($this->getConfig()->get("player-not-found", ""), 
				[
					"{player}" => $args[0] ?? ""
				]
			));
			return true;
		}
		
		if(count($args) < 1) {
			$sender->sendMessage($this->getUsage());
			return true;
		}
		
		$ping = $target->getPing();
		
		if($sender instanceof Player) {
			if($sender->getName() == $target->getName()) {
				$sender->sendMessage(Main::replace($this->getConfig()->get("self-ping", ""), 
					[
						"{ping}" => $ping
					]
				));
			}
			return true;
		}
		
		
		
		if ($sender->hasPermission("kygekpingtps.ping-others")) {
			$sender->sendMessage(Main::replace($this->getConfig()->get("other-ping", ""), 
				[
					"{ping}" => $ping,
					"{player}" => $target->getName()
				]
			));
		}else{
			$sender->sendMessage(Main::replace($this->getConfig()->get("no-other-ping-perm", "")));
			return false;
		}
		return true;
	}
}