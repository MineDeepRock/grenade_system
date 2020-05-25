<?php


namespace grenade_system\pmmp\events;


use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class FlameBottleExplodeEvent extends GrenadeExplodeEvent
{
    /**
     * @var Player
     */
    private $owner;
    /**
     * @var Player
     */
    private $victim;

    public function __construct(PluginBase $plugin,Player $owner, Player $victim) {
        $this->owner = $owner;
        $this->victim = $victim;
        parent::__construct($plugin);
    }

    /**
     * @return Player
     */
    public function getOwner(): Player {
        return $this->owner;
    }

    /**
     * @return Player
     */
    public function getVictim(): Player {
        return $this->victim;
    }
}