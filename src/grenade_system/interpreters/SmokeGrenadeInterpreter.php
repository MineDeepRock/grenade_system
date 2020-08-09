<?php


namespace grenade_system\interpreters;


use grenade_system\models\FragGrenade;
use grenade_system\models\SmokeGrenade;
use grenade_system\clients\SmokeGrenadeClient;
use grenade_system\pmmp\entities\GrenadeEntity;
use grenade_system\pmmp\events\ConsumedGrenadeEvent;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class SmokeGrenadeInterpreter extends GrenadeInterpreter
{
    private $handler;

    public function __construct(Player $owner,TaskScheduler $scheduler) {
        parent::__construct($owner,new SmokeGrenade(), $scheduler);
    }

    public function stop() {
        $e = new ConsumedGrenadeEvent($this->owner, new FragGrenade());
        $e->call();

        if ($this->handler !== null) {
            $this->handler->cancel();
        }
    }

    public function explode(GrenadeEntity $entity): void {
        $level = $entity->getLevel();

        $this->handler = $this->scheduler->scheduleDelayedRepeatingTask(new ClosureTask(function (int $tick) use ($level, $entity): void {
            if ($this->owner->isOnline()) {
                for ($i = 0; $i < 15; ++$i) {
                    SmokeGrenadeClient::explodeParticle($level, new Vector3(
                        $entity->getX() + rand(-1, 1),
                        $entity->getY(),
                        $entity->getZ() + rand(-1, 1)
                    ));
                }
            }
        }), 20 * SmokeGrenade::DELAY, 20 * 0.5);
    }
}