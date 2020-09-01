<?php


namespace box_system\pmmp\items;


use pocketmine\item\Item;

class SpawnDecoyBoxItem extends BoxItem
{
    public const ITEM_ID = Item::ARMOR_STAND;

    public function __construct() {
        parent::__construct(self::ITEM_ID, 0, "デコイ");
        $this->setCustomName($this->getName());
    }
}