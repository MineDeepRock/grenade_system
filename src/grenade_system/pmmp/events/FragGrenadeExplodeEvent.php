<?php


namespace grenade_system\pmmp\events;


use pocketmine\Player;

class FragGrenadeExplodeEvent extends GrenadeExplodeEvent
{
    /**
     * @var Player
     */
    private $owner;
    /**
     * @var Player
     */
    private $victim;
    /**
     * @var float
     */
    private $distance;

    public function __construct(Player $owner, Player $victim, float $distance) {
        $this->owner = $owner;
        $this->victim = $victim;
        $this->distance = $distance;
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

    /**
     * @return float
     */
    public function getDistance(): float {
        return $this->distance;
    }
}