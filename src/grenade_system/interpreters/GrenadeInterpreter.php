<?php

namespace grenade_system\interpreters;

use grenade_system\models\Grenade;
use grenade_system\pmmp\entities\GrenadeEntity;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\scheduler\TaskScheduler;

abstract class GrenadeInterpreter
{
    /**
     * @var Player
     */
    protected $owner;
    /**
     * @var Grenade
     */
    protected $grenade;
    /**
     * @var TaskScheduler
     */
    protected $scheduler;

    public function __construct(Player $owner, Grenade $grenade, TaskScheduler $scheduler) {
        $this->owner = $owner;
        $this->grenade = $grenade;
        $this->scheduler = $scheduler;
    }

    protected function getWithinRangePlayers(Vector3 $pos): array {
        if ($this->owner->getLevel() === null) return [];

        $players = $this->owner->getLevel()->getPlayers();
        return array_filter($players, function ($player) use ($pos) {
            return $pos->distance($player->getPosition()) <= $this->grenade::RANGE;
        });
    }

    abstract function explode(GrenadeEntity $entity): void;
}