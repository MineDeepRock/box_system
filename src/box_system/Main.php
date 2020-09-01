<?php

namespace box_system;

use box_system\pmmp\entities\AmmoBoxEntity;
use box_system\pmmp\entities\DecoyBoxEntity;
use box_system\pmmp\entities\FlareBoxEntity;
use box_system\pmmp\entities\MedicineBoxEntity;
use box_system\pmmp\items\SpawnAmmoBoxItem;
use box_system\pmmp\items\SpawnDecoyBoxItem;
use box_system\pmmp\items\SpawnFlareBoxItem;
use box_system\pmmp\items\SpawnMedicineBoxItem;
use box_system\listener\BoxListener;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    public function onEnable() {

        ItemFactory::registerItem(new SpawnAmmoBoxItem(), true);
        Item::addCreativeItem(Item::get(SpawnAmmoBoxItem::ITEM_ID));
        ItemFactory::registerItem(new SpawnMedicineBoxItem(), true);
        Item::addCreativeItem(Item::get(SpawnMedicineBoxItem::ITEM_ID));
        ItemFactory::registerItem(new SpawnFlareBoxItem(), true);
        Item::addCreativeItem(Item::get(SpawnFlareBoxItem::ITEM_ID));
        ItemFactory::registerItem(new SpawnDecoyBoxItem(), true);
        Item::addCreativeItem(Item::get(SpawnFlareBoxItem::ITEM_ID));

        Entity::registerEntity(AmmoBoxEntity::class, true, ['AmmoBox']);
        Entity::registerEntity(MedicineBoxEntity::class, true, ['MedicineBox']);
        Entity::registerEntity(FlareBoxEntity::class, true, ['FlareBox']);
        Entity::registerEntity(DecoyBoxEntity::class, true, ['DecoyBox']);

        $this->getServer()->getPluginManager()->registerEvents(new BoxListener($this), $this);
    }
}