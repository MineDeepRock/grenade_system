<?php


namespace grenade_system\pmmp\entities;


use grenade_system\interpreters\FragGrenadeInterpreter;
use grenade_system\models\FlameBottle;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class FragGrenadeEntity extends GrenadeEntity
{
    public $scale = 0.5;

    public $skinName = "FragGrenade";
    public $geometryId = "geometry.FragGrenade";
    public $geometryName = "FragGrenade.geo.json";

    public function __construct(Level $level,
                                Player $owner,
                                TaskScheduler $scheduler) {
        $this->interpreter = new FragGrenadeInterpreter(
            $owner,
            $scheduler);
        parent::__construct($level, $owner, $scheduler);

        $this->interpreter->explode($this);
    }
}