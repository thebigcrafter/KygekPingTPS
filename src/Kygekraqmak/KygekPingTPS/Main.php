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

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

use KygekTeam\KtpmplCfs\KtpmplCfs;

class Main extends PluginBase {
	
	private const IS_DEV = true;
	public const PREFIX = TextFormat::YELLOW . "[KygekPingTPS] ";
	private static self $instance;

	public function onEnable() {
		self::$instance = $this;
		$this->saveDefaultConfig();
		/** @phpstan-ignore-next-line */
        if (self::IS_DEV) {
            $this->getLogger()->warning("This plugin is running on a development version. There might be some major bugs. If you found one, please submit an issue in https://github.com/KygekTeam/KygekPingTPS/issues.");
        }
        KtpmplCfs::checkUpdates($this);
        KtpmplCfs::checkConfig($this, "2.0");
        
        $this->getServer()->getCommandMap()->registerAll("KygekPingTPS", [new PingCommand($this), new TPSCommand($this)]);
	}

	public static function getInstance() : self {
		return self::$instance;
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
