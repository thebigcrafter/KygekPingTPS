<?php

declare(strict_types=1);

namespace Kygekraqmak\KygekPingTPS;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use Kygekraqmak\KygekPingTPS\Main;

class Ping {
	
	public $other;
	public $pingself;
	public $pingother;
	public $prefix;
	public $noperm;
	public $notfound;
	public $usage;
	
	public function PingCommand(CommandSender $sender, Command $cmd, string $label, array $args) {
		$this->prefix = TextFormat::YELLOW . "[KygekPingTPS] ";
		$this->noperm = $this->prefix . TextFormat::RED . "You do not have permission to use this command";
		$this->usage = $this->prefix . TextFormat::WHITE . "Usage: /ping <player>";
		if (isset($args[0])) {
			$this->other = Main::getInstance()->getServer()->getPlayerExact($args[0]);
			$this->notfound = $this->prefix . TextFormat::RED . "Player was not found";
			if ($this->other == null) {
                $sender->sendMessage($this->notfound);
                return;
            }
			$this->pingother = TextFormat::AQUA . $this->other->getPing();
		}
		if (!$sender instanceof Player) {
			if (count($args) < 1) $sender->sendMessage($this->usage);
			elseif (isset($args[0])) {
				if (!$this->other instanceof Player) $sender->sendMessage($this->notfound);
				else $sender->sendMessage($this->prefix . TextFormat::GREEN . $this->other->getName() . "'s current ping: " . $this->pingother);
			}
		} else {
			if ($sender->hasPermission("kygekpingtps.ping")) {
				if (count($args) < 1) $sender->sendMessage($this->prefix . TextFormat::GREEN . "Your current ping: " . TextFormat::AQUA . $sender->getPing());
				elseif (isset($args[0])) {
					if (!$this->other instanceof Player) $sender->sendMessage($this->notfound);
					else $sender->sendMessage($this->prefix . TextFormat::GREEN . $this->other->getName() . "'s current ping: " . $this->pingother);
				}
			} else $sender->sendMessage($this->noperm);
		}
	}
	
}
