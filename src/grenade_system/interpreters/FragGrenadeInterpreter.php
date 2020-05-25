<?php


namespace grenade_system\interpreters;


use grenade_system\controllers\EventController;
use grenade_system\models\FragGrenade;
use grenade_system\clients\FragGrenadeClient;
use grenade_system\pmmp\entities\GrenadeEntity;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class FragGrenadeInterpreter extends GrenadeInterpreter
{
    public function __construct(Player $owner, TaskScheduler $scheduler) {
        parent::__construct($owner, new FragGrenade(), $scheduler);
    }

    function explode(GrenadeEntity $entity): void {
        $this->scheduler->scheduleDelayedTask(new ClosureTask(function (int $i) use ($entity): void {
            if ($entity->isAlive()) $entity->kill();
            FragGrenadeClient::explodeParticle($entity->getLevel(), $entity->getPosition());
            $players = $this->getWithinRangePlayers($entity->getPosition());
            $controller = EventController::getInstance();
            foreach ($players as $player) {
                $controller->callFragGrenadeExplodeEvent($this->owner, $player, $entity->getPosition()->distance($player->getPosition()));
            }
        }), 20 * $this->grenade::DELAY);
    }
}