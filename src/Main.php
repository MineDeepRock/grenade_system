<?php


use grenade_system\listener\GrenadeListener;
use grenade_system\pmmp\entities\FlameBottleEntity;
use grenade_system\pmmp\entities\FragGrenadeEntity;
use grenade_system\pmmp\entities\SmokeGrenadeEntity;
use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    public function onEnable() {
        new \grenade_system\controllers\EventController($this);

        $this->getLogger()->info("GrenadeSystemを読み込みました");
        Entity::registerEntity(SmokeGrenadeEntity::class, true, ['SmokeGrenade']);
        Entity::registerEntity(FragGrenadeEntity::class, true, ['FragGrenade']);
        Entity::registerEntity(FlameBottleEntity::class, true, ['FlameBottle']);

        $this->getServer()->getPluginManager()->registerEvents(new GrenadeListener($this), $this);
    }
}