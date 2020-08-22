<?php

declare(strict_types=1);

namespace Kygekraqmak\KygekPingTPS;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use Kygekraqmak\KygekPingTPS\Main;

class TPS {
	
	public $tps;
	public $prefix;
	public $noperm;
	
	public function TPSCommand(CommandSender $sender, Command $cmd, string $label, array $args) {
		$this->tps = TextFormat::AQUA . Main::getInstance()->getServer()->getTicksPerSecond();
		$this->prefix = TextFormat::YELLOW . "[KygekPingTPS] ";
		$this->noperm = $this->prefix . TextFormat::RED . "You do not have permission to use this command";
		if ($sender->hasPermission("kygekpingtps.tps")) $sender->sendMessage($this->prefix . TextFormat::GREEN . "Current server TPS: " . $this->tps);
		else $sender->sendMessage($this->noperm);
	}
	
}
