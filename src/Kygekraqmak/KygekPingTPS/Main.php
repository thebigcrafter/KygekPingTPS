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

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

use JackMD\UpdateNotifier\UpdateNotifier;

class Main extends PluginBase {
	private static $instance;

	public static function getInstance() : self {
		return self::$instance;
	}

	public function onEnable() {
		self::$instance = $this;
		$this->saveDefaultConfig();
		$this->checkConfig();
		
        if ($this->getConfig()->get("check-updates", true)) {
			UpdateNotifier::checkUpdate($this->getDescription()->getName(), $this->getDescription()->getVersion());
        }
        $this->getServer()->getCommandMap()->registerAll("KygekPingTPS", [new PingCommand($this), new TPSCommand($this)]);
	}

    public function checkConfig() {
        if ($this->getConfig()->get("config-version") != "1.1") {
            $this->getLogger()->notice("Your configuration file is outdated, updating the config.yml...");
            $this->getLogger()->notice("The old configuration file can be found at config_old.yml");
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "config_old.yml");
            $this->saveDefaultConfig();
            $this->getConfig()->reload();
        }
    }

	public static function replace(string $string, array $replacements = [], bool $default = true) : string {
	    $defaults = [
	        "{prefix}" => str_replace("&", "§", self::getInstance()->getConfig()->get("prefix") ?? "[KygekPingTPS]"),
            "&" => "§"
        ];
        
        $replacements = $default ? array_merge($replacements, $defaults) : $replacements;
        
	    return strtr($string, $replacements);
    }
}
