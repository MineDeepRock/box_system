<?php


namespace box_system\models;


abstract class Box
{
    const NAME = "";
    const SECOND_LIMIT = 0;
    const RANGE = 0;

    static function fromString(string $text): ?Box {
        switch ($text) {
            case AmmoBox::NAME:
                return new AmmoBox();
                break;
            case FlareBox::NAME:
                return new FlareBox();
                break;
            case MedicineBox::NAME:
                return new MedicineBox();
                break;
        }

        return null;
    }
}