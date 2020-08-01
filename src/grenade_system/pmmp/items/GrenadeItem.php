<?php


namespace grenade_system\pmmp\items;


use grenade_system\models\FlameBottle;
use grenade_system\models\FragGrenade;
use grenade_system\models\Grenade;
use grenade_system\models\SmokeGrenade;
use pocketmine\item\Item;

abstract class GrenadeItem extends Item
{
    static function fromGrenade(Grenade $grenade): ?GrenadeItem {
        switch ($grenade::NAME) {
            case FlameBottle::NAME:
                return new FlameBottleItem();
                break;
            case FragGrenade::NAME:
                return new FragGrenadeItem();
                break;
            case SmokeGrenade::NAME:
                return new SmokeGrenadeItem();
                break;
        }

        return null;
    }
}