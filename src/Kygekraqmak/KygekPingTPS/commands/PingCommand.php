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

namespace Kygekraqmak\KygekPingTPS\commands;

use Kygekraqmak\KygekPingTPS\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;

class PingCommand extends PluginCommand {
	
	/** @var Main $plugin */
	protected $plugin;

	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
		parent::__construct("ping", $plugin);
		$this->setDescription("Current ping of a player.");
		$this->setUsage("/ping <player>");
		$this->setPermission("kygekpingtps.ping");
	}
	
	public function execute(CommandSender $sender, string $commandLabel, array $args){
		$this->plugin->getConfig()->reload();
		if (!$this->testPermission($sender)) {
			$sender->sendMessage(Main::getMessage("message.no-permission", "&cYou do not have permission to use this command!"));
			return false;
		}
		
		$target_name = implode(' ', $args);
		$target = $this->plugin->getServer()->getPlayer($target_name);
		
		if (!empty($target_name)) {
			if (is_null($target)) {
				$sender->sendMessage(Main::getMessage("message.player-not-found", "&cPlayer {player} was not found!", ["{player}" => $target_name]));
				return true;
			}
			
			if ($sender !== $target) {
				if ($sender->hasPermission("kygekpingtps.ping.others")) {
					$sender->sendMessage(Main::getMessage("message.ping-others", "{player}'s current ping: &b{ping}&rms.", ["{ping}" => $target->getPing(), "{player}" => $target->getName()]));
				} else
					$sender->sendMessage(Main::getMessage("message.no-other-ping-perm", "&cYou do not have permission to see other player's ping!"));
				return true;
			}
		}
		
		if ($sender instanceof Player) {
			if (!$sender->hasPermission("kygekpingtps.ping.self")) {
				$sender->sendMessage(Main::getMessage("message.no-self-ping-perm", "&cYou do not have permission to see your ping!"));
				return true;
			}
			$sender->sendMessage(Main::getMessage("message.ping-self", "Your current ping: &b{ping}&rms.", ["{ping}" => $sender->getPing()]));
		} else $sender->sendMessage($this->getUsage());
		return true;
	}
	
}