<?php


namespace grenade_system\pmmp\clients;


use pocketmine\level\Level;
use pocketmine\level\particle\EntityFlameParticle;
use pocketmine\math\Vector3;

class FlameBottleClient
{
    static function explodeParticle(Level $level, Vector3 $pos): void {
        $level->addParticle(new EntityFlameParticle($pos));
    }

    static function playSound(Level $level, Vector3 $pos): void {
        //TODO:実装
    }
}