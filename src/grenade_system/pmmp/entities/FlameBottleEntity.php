<?php


namespace grenade_system\pmmp\entities;


use grenade_system\interpreters\FlameBottleInterpreter;
use grenade_system\models\FlameBottle;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class FlameBottleEntity extends GrenadeEntity
{
    public $skinName = "FlameBottle";
    public $geometryId = "geometry.FlameBottle";
    public $geometryName = "FlameBottle.geo.json";

    public function __construct(Level $level,
                                Player $owner,
                                TaskScheduler $scheduler) {
        $this->interpreter = new FlameBottleInterpreter(
            $owner,
            $scheduler);

        parent::__construct($level, $owner,$scheduler);

        $this->interpreter->explode($this);

        $scheduler->scheduleDelayedTask(new ClosureTask(function (int $tick) : void {
            if ($this->isAlive()) $this->kill();
        }), 20 * FlameBottle::DURATION);
    }

    protected function onDeath(): void {
        $this->interpreter->stop();
        parent::onDeath();
    }
}