<?php


namespace grenade_system\controllers;


use grenade_system\pmmp\events\FlameBottleExplodeEvent;
use grenade_system\pmmp\events\FragGrenadeExplodeEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class EventController
{
    private static $instance;
    private $plugin;

    public function __construct(PluginBase $plugin) {
        $this->plugin = $plugin;
        self::$instance = $this;
    }

    /**
     * @return EventController
     */
    public static function getInstance(): EventController {
        return self::$instance;
    }

    public function callFragGrenadeExplodeEvent(Player $owner, Player $victim, float $distance): void {
        $event = new FragGrenadeExplodeEvent($this->plugin, $owner, $victim, $distance);
        $event->call();
    }
    public function callFlameBottleExplodeEvent(Player $owner, Player $victim): void {
        $event = new FlameBottleExplodeEvent($this->plugin, $owner, $victim);
        $event->call();
    }
}