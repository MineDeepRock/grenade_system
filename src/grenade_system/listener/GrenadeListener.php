<?php

namespace grenade_system\listener;

use grenade_system\pmmp\entities\FlameBottleEntity;
use grenade_system\pmmp\entities\FragGrenadeEntity;
use grenade_system\pmmp\entities\SmokeGrenadeEntity;
use grenade_system\pmmp\events\FlameBottleExplodeEvent;
use grenade_system\pmmp\events\FragGrenadeExplodeEvent;
use grenade_system\pmmp\items\FlameBottleItem;
use grenade_system\pmmp\items\FragGrenadeItem;
use grenade_system\pmmp\items\SmokeGrenadeItem;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\item\ItemFactory;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class GrenadeListener implements Listener
{
    private $plugin;

    public function __construct(PluginBase $plugin) {
        $this->plugin = $plugin;
    }

    public function spawnFragGrenadeEntity(Player $player) {
        $player->getInventory()->remove(ItemFactory::get(FragGrenadeItem::ITEM_ID, 0, 1));

        $fragGrenade = new FragGrenadeEntity(
            $player->getLevel(),
            $player,
            $this->plugin->getScheduler());
        $fragGrenade->setMotion($fragGrenade->getMotion()->multiply(1));
        $fragGrenade->spawnToAll();
    }

    public function spawnSmokeGrenadeEntity(Player $player) {
        $player->getInventory()->remove(ItemFactory::get(SmokeGrenadeItem::ITEM_ID, 0, 1));

        $fragGrenade = new SmokeGrenadeEntity(
            $player->getLevel(),
            $player,
            $this->plugin->getScheduler());
        $fragGrenade->setMotion($fragGrenade->getMotion()->multiply(1));
        $fragGrenade->spawnToAll();
    }

    public function spawnFlameBottleEntity(Player $player) {
        $player->getInventory()->remove(ItemFactory::get(FlameBottleItem::ITEM_ID, 0, 1));

        $fragGrenade = new FlameBottleEntity(
            $player->getLevel(),
            $player,
            $this->plugin->getScheduler());
        $fragGrenade->setMotion($fragGrenade->getMotion()->multiply(1));
        $fragGrenade->spawnToAll();
    }

    public function onTapBlock(PlayerInteractEvent $event) {
        if ($event->getAction() !== PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
            $player = $event->getPlayer();
            $item = $player->getInventory()->getItemInHand();
            switch ($item->getId()) {
                case FragGrenadeItem::ITEM_ID:
                    $this->spawnFragGrenadeEntity($player);
                    break;
                case SmokeGrenadeItem::ITEM_ID:
                    $this->spawnSmokeGrenadeEntity($player);
                    break;
                case FlameBottleItem::ITEM_ID:
                    $this->spawnFlameBottleEntity($player);
                    break;
            }
        }
    }

    public function onTapAir(DataPacketReceiveEvent $event) {
        $packet = $event->getPacket();
        if ($packet instanceof LevelSoundEventPacket) {
            if ($packet->sound === LevelSoundEventPacket::SOUND_ATTACK_NODAMAGE) {
                $player = $event->getPlayer();
                $item = $event->getPlayer()->getInventory()->getItemInHand();
                switch ($item->getId()) {
                    case FragGrenadeItem::ITEM_ID:
                        $this->spawnFragGrenadeEntity($player);
                        break;
                    case SmokeGrenadeItem::ITEM_ID:
                        $this->spawnSmokeGrenadeEntity($player);
                        break;
                    case FlameBottleItem::ITEM_ID:
                        $this->spawnFlameBottleEntity($player);
                        break;
                }
            }
        }
    }
}