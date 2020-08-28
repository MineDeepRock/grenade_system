<?php


namespace grenade_system\clients;


use grenade_system\models\FlameBottle;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockIds;
use pocketmine\block\Fire;
use pocketmine\item\FlintSteel;
use pocketmine\level\Level;
use pocketmine\level\particle\EntityFlameParticle;
use pocketmine\level\particle\LavaParticle;
use pocketmine\math\Vector3;

class FlameBottleClient
{
    static function playSound(Level $level, Vector3 $pos): void {
        //TODO:実装
    }

    static function summonFireParticle(Level $level, Vector3 $center): void {
        for ($x = -FlameBottle::RANGE; $x <= FlameBottle::RANGE; ++$x) {
            for ($z = -FlameBottle::RANGE; $z <= FlameBottle::RANGE; ++$z) {
                for ($y = 0; $y <= 2; ++$y) {
                    $pos = $center->add($x, $y, $z);
                    $block = $level->getBlockAt($pos->getX(), $pos->getY(), $pos->getZ());
                    if ($block->getId() === BlockIds::AIR) {
                        $level->addParticle(new LavaParticle($pos));
                    //    $level->setBlock($pos, BlockFactory::get(Block::FIRE), true);
                    }
                }
            }
        }
    }
}