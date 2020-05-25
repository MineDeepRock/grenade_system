<?php


namespace grenade_system\clients;

use grenade_system\models\SmokeGrenade;
use pocketmine\level\Level;
use pocketmine\level\particle\MobSpawnParticle;
use pocketmine\math\Vector3;

class SmokeGrenadeClient
{
    static function explodeParticle(Level $level, Vector3 $pos): void {
        $level->addParticle(new MobSpawnParticle($pos, SmokeGrenade::RANGE, 3));
    }

    static function playSound(Level $level, Vector3 $pos): void {
        //TODO:実装
    }
}