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

use Kygekraqmak\KygekPingTPS\commands\PingCommand;
use Kygekraqmak\KygekPingTPS\commands\TPSCommand;
use KygekTeam\KtpmplCfs\KtpmplCfs;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase {

    /** @var string */
    public static $prefix = TextFormat::YELLOW . "[KygekPingTPS] " . TextFormat::RESET;

    /** @var self */
    private static $instance;

    public function onEnable() {
        self::$instance = $this;
        $this->saveDefaultConfig();

        KtpmplCfs::checkUpdates($this);
        KtpmplCfs::checkConfig($this, "1.1");

        $this->getServer()->getCommandMap()->registerAll("KygekPingTPS", [new PingCommand($this), new TPSCommand($this)]);
        self::$prefix = TextFormat::colorize($this->getConfig()->get("message-prefix", self::$prefix)) . TextFormat::RESET;
    }

    public static function getInstance() : self {
        return self::$instance;
    }

    /**
     * @param string $key
     * @param string $defaultValue
     * @param string[] $replacements
     * @return string
     */
    public static function getMessage(string $key, string $defaultValue = "", array $replacements = []) : string {
        return self::$prefix . TextFormat::colorize(strtr(Main::getInstance()->getConfig()->get($key, $defaultValue), $replacements));
    }

}