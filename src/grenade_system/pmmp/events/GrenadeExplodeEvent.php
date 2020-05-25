<?php

namespace grenade_system\pmmp\events;

use pocketmine\event\plugin\PluginEvent;
use pocketmine\plugin\Plugin;

abstract class GrenadeExplodeEvent extends PluginEvent{
    public function __construct(Plugin $plugin) {
        parent::__construct($plugin);
    }
}