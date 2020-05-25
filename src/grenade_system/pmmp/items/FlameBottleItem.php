<?php


namespace grenade_system\pmmp\items;


use pocketmine\item\Item;

class FlameBottleItem extends Item
{
    public const ITEM_ID = Item::BLAZE_POWDER;

    public function __construct() {
        parent::__construct(self::ITEM_ID, 0, "火炎瓶");
        $this->setCustomName($this->getName());
    }
}