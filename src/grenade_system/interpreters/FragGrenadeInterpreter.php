<?php


namespace grenade_system\interpreters;


use grenade_system\models\FragGrenade;
use grenade_system\clients\FragGrenadeClient;
use grenade_system\pmmp\entities\GrenadeEntity;
use grenade_system\pmmp\events\ConsumedGrenadeEvent;
use grenade_system\pmmp\events\FragGrenadeExplodeEvent;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class FragGrenadeInterpreter extends GrenadeInterpreter
{
    public function __construct(Player $owner, TaskScheduler $scheduler) {
        parent::__construct($owner, new FragGrenade(), $scheduler);
    }

    function explode(GrenadeEntity $entity): void {
        $e = new ConsumedGrenadeEvent($this->owner, new FragGrenade());
        $e->call();

        $this->scheduler->scheduleDelayedTask(new ClosureTask(function (int $i) use ($entity): void {
            if ($entity->isAlive()) $entity->kill();
            FragGrenadeClient::explodeParticle($entity->getLevel(), $entity->getPosition());
            $players = $this->getWithinRangePlayers($entity->getPosition());
            foreach ($players as $player) {
                $event = new FragGrenadeExplodeEvent($this->owner, $player, $entity->getPosition()->distance($player->getPosition()));
                $event->call();
            }
        }), 20 * $this->grenade::DELAY);
    }
}