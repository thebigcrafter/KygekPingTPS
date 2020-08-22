<?php

declare(strict_types=1);

namespace Kygekraqmak\KygekPingTPS;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use Kygekraqmak\KygekPingTPS\Ping;
use Kygekraqmak\KygekPingTPS\TPS;

class Main extends PluginBase {
	
	private static $instance;
	
	public function onEnable() {
		self::$instance = $this;
	}
	
	public static function getInstance() {
		return self::$instance;
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
		switch ($cmd->getName()) {
			case "tps":
				$tps = new TPS();
				$tps->TPSCommand($sender, $cmd, $label, $args);
			break;
			case "ping":
				$ping = new Ping();
				$ping->PingCommand($sender, $cmd, $label, $args);
			break;
		}
		return true;
	}
	
}
