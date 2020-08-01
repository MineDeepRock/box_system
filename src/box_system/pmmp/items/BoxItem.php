<?php


namespace box_system\pmmp\items;


use box_system\models\AmmoBox;
use box_system\models\Box;
use box_system\models\FlareBox;
use box_system\models\MedicineBox;
use pocketmine\item\Item;

abstract class BoxItem extends Item
{
    static function fromBox(Box $box): ?BoxItem {
        switch ($box::NAME) {
            case AmmoBox::NAME:
                return new SpawnAmmoBoxItem();
                break;
            case FlareBox::NAME:
                return new SpawnFlareBoxItem();
                break;
            case MedicineBox::NAME:
                return new SpawnMedicineBoxItem();
                break;
        }

        return null;
    }
}