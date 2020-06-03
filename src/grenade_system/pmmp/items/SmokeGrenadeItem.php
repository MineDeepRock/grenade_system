<?php


namespace grenade_system\pmmp\items;


use pocketmine\item\Item;

class SmokeGrenadeItem extends GrenadeItem
{
    public const ITEM_ID = Item::MAGMA_CREAM;

    public function __construct() {
        parent::__construct(self::ITEM_ID, 0, "スモーク");
        $this->setCustomName($this->getName());
    }
}