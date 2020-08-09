<?php


namespace grenade_system\pmmp\events;


use grenade_system\models\Grenade;
use pocketmine\event\Event;
use pocketmine\Player;

class ConsumedGrenadeEvent extends Event
{
    private $owner;
    private $grenade;

    public function __construct(Player $owner, Grenade $grenade) {
        $this->owner = $owner;
        $this->grenade = $grenade;
    }

    /**
     * @return Player
     */
    public function getOwner(): Player {
        return $this->owner;
    }

    /**
     * @return Grenade
     */
    public function getGrenade(): Grenade {
        return $this->grenade;
    }
}