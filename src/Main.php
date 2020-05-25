<?php


use box_system\pmmp\entities\AmmoBoxEntity;
use box_system\pmmp\entities\FlareBoxEntity;
use box_system\pmmp\entities\MedicineBoxEntity;
use box_system\pmmp\items\SpawnAmmoBoxItem;
use box_system\pmmp\items\SpawnFlareBoxItem;
use box_system\pmmp\items\SpawnMedicineBoxItem;
use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    public function onEnable() {

        $this->getLogger()->info("BoxSystemを読み込みました");
        ItemFactory::registerItem(new SpawnAmmoBoxItem(), true);
        Item::addCreativeItem(Item::get(SpawnAmmoBoxItem::ITEM_ID));
        ItemFactory::registerItem(new SpawnMedicineBoxItem(), true);
        Item::addCreativeItem(Item::get(SpawnMedicineBoxItem::ITEM_ID));
        ItemFactory::registerItem(new SpawnFlareBoxItem(), true);
        Item::addCreativeItem(Item::get(SpawnFlareBoxItem::ITEM_ID));

        Entity::registerEntity(AmmoBoxEntity::class, true, ['AmmoBox']);
        Entity::registerEntity(MedicineBoxEntity::class, true, ['MedicineBox']);
        Entity::registerEntity(FlareBoxEntity::class, true, ['FlareBox']);

        $this->getServer()->getPluginManager()->registerEvents(new BoxListener($this), $this);
    }
}