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
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class PingCommand extends Command {

    /** @var Main $plugin */
    protected $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        parent::__construct("ping", "Current ping of a player", "/ping [player]");
        $this->setPermission("kygekpingtps.ping");
    }

    private function getConfig() : Config {
        return $this->plugin->getConfig();
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool {
        $this->getConfig()->reload();

        if (count($args) === 0) {
            if (!$sender instanceof Player) {
                $sender->sendMessage("Usage: /ping <player>");
                return true;
            }

            if (!$sender->hasPermission("kygekpingtps.ping.self" && !$this->testPermission($sender))) {
                $sender->sendMessage(Main::getMessage("no-self-ping-perm", "&cYou do not have permission to see your ping!"));
                return true;
            }

            $ping = (string) $sender->getPing();
            $sender->sendMessage(Main::getMessage("self-ping", "Your current ping: &b{ping}&rms", ["{ping}" => $ping]));
            return true;
        }

        if (!$sender->hasPermission("kygekpingtps.ping.others" && !$this->testPermission($sender))) {
            $sender->sendMessage(Main::getMessage("no-other-ping-perm", "&cYou do not have permission to see other player's ping!"));
            return true;
        }

        if (is_null($targetPlayer = $this->plugin->getServer()->getPlayer($args[0]))) {
            $sender->sendMessage(Main::getMessage("player-not-found", "&cPlayer {player} was not found!", ["{player}" => $args[0]]));
            return true;
        }

        $ping = (string) $targetPlayer->getPing();
        $sender->sendMessage(Main::getMessage("other-ping", "{player}'s current ping: &b{ping}&rms", [
            "{ping}" => $ping, "{player}" => $targetPlayer->getName()
        ]));

        return true;
    }
}