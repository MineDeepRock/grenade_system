<?php


namespace grenade_system\pmmp\events;


use pocketmine\Player;

class PlayerBurnedByFlameEvent extends GrenadeExplodeEvent
{
    /**
     * @var Player
     */
    private $owner;
    /**
     * @var Player
     */
    private $victim;

    public function __construct(Player $owner, Player $victim) {
        $this->owner = $owner;
        $this->victim = $victim;
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