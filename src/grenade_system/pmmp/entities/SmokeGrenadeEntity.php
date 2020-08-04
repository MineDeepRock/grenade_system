<?php


namespace grenade_system\pmmp\entities;


use grenade_system\interpreters\SmokeGrenadeInterpreter;
use grenade_system\models\SmokeGrenade;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class SmokeGrenadeEntity extends GrenadeEntity
{
    public $skinName = "SmokeGrenade";
    public $geometryId = "geometry.SmokeGrenade";
    public $geometryName = "SmokeGrenade.geo.json";

    public function __construct(Level $level,
                                Player $owner,
                                TaskScheduler $scheduler) {
        $this->interpreter = new SmokeGrenadeInterpreter(
            $owner,
            $scheduler);
        parent::__construct($level, $owner, $scheduler);

        $this->interpreter->explode($this);

        $scheduler->scheduleDelayedTask(new ClosureTask(function (int $tick): void {
            if ($this->isAlive()) $this->kill();
        }), 20 * SmokeGrenade::DURATION);
    }

    protected function onDeath(): void {
        $this->interpreter->stop();
        parent::onDeath();
    }
}