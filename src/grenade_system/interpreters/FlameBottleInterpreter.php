<?php


namespace grenade_system\interpreters;


use grenade_system\models\FlameBottle;
use grenade_system\clients\FlameBottleClient;
use grenade_system\pmmp\entities\GrenadeEntity;
use grenade_system\pmmp\events\FlameBottleExplodeEvent;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class FlameBottleInterpreter extends GrenadeInterpreter
{
    private $handler;

    public function __construct(Player $owner, TaskScheduler $scheduler) {
        parent::__construct($owner, new FlameBottle(), $scheduler);
        $this->grenade = new FlameBottle();
    }

    public function stop() {
        if ($this->handler) {
            $this->handler->cancel();
        }
    }

    function explode(GrenadeEntity $entity): void {
        $this->handler = $this->scheduler->scheduleDelayedRepeatingTask(new ClosureTask(function (int $tick) use ($entity): void {
            if ($this->owner->isOnline()) {
                for ($i = 0; $i < 15; ++$i) {
                    FlameBottleClient::explodeParticle($entity->getLevel(), new Vector3(
                        $entity->getX() + rand(-FlameBottle::RANGE, FlameBottle::RANGE),
                        $entity->getY() + rand(0, 2),
                        $entity->getZ() + rand(-FlameBottle::RANGE, FlameBottle::RANGE)
                    ));
                }
                $players = $this->getWithinRangePlayers($entity->getPosition());
                foreach ($players as $player) {
                    $event = new FlameBottleExplodeEvent($this->owner, $player);
                    $event->call();
                }
            }
        }), 20 * FlameBottle::DELAY, 20 * 0.5);
    }
}