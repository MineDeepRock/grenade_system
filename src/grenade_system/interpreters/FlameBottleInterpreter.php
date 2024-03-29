<?php


namespace grenade_system\interpreters;


use grenade_system\models\FlameBottle;
use grenade_system\clients\FlameBottleClient;
use grenade_system\models\FragGrenade;
use grenade_system\pmmp\entities\GrenadeEntity;
use grenade_system\pmmp\events\ConsumedGrenadeEvent;
use grenade_system\pmmp\events\FragGrenadeExplodeEvent;
use grenade_system\pmmp\events\PlayerBurnedByFlameEvent;
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
        $e = new ConsumedGrenadeEvent($this->owner, new FlameBottle());
        $e->call();
        if ($this->handler) {
            $this->handler->cancel();
        }
    }

    function explode(GrenadeEntity $entity): void {
        $this->handler = $this->scheduler->scheduleDelayedRepeatingTask(new ClosureTask(function (int $tick) use ($entity): void {
            if ($this->owner->isOnline()) {
                FlameBottleClient::summonFireParticle($entity->getLevel(), $entity->getPosition());

                $players = $this->getWithinRangePlayers($entity->getPosition());
                foreach ($players as $player) {
                    if (abs($player->getY() - $entity->getY()) > 2) continue;

                    $event = new PlayerBurnedByFlameEvent($this->owner, $player);
                    $event->call();
                }
            }
        }), 20 * FlameBottle::DELAY, 20 * 1);
    }
}