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
        	if (class_exists("\JackMD\UpdateNotifier\UpdateNotifier")) {
            	\JackMD\UpdateNotifier\UpdateNotifier::checkUpdate($this->getDescription()->getName(), $this->getDescription()->getVersion());
            } else {
            	$this->getLogger()->notice("JackMD\UpdateNotifier is not installed on your server, install it or turn off check-updates on your config");
            }
        }
        $this->getServer()->getCommandMap()->register("ping", new PingCommand($this));
        $this->getServer()->getCommandMap()->register("tps", new TPSCommand($this));
	}

    public function checkConfig() {
    	$current_version = $this->getDescription()->getMap()["config"] ?? "0.0";
    	//$this->getLogger()->notice($current_version);
        if ($this->getConfig()->get("config-version") !== $current_version) {
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