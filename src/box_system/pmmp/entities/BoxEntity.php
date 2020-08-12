<?php


namespace box_system\pmmp\entities;


use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\Player;
use pocketmine\scheduler\TaskScheduler;

abstract class BoxEntity extends GadgetEntity
{
    /**
     * @var Player
     */
    private $owner;

    public function __construct(Level $level, Player $owner, TaskScheduler $scheduler, ?CompoundTag $nbt = null) {
        $this->owner = $owner;
        $nbt = $nbt ?? new CompoundTag('', [
                'Pos' => new ListTag('Pos', [
                    new DoubleTag('', $owner->getX()),
                    new DoubleTag('', $owner->getY() + 0.5),
                    new DoubleTag('', $owner->getZ())
                ]),
                'Motion' => new ListTag('Motion', [
                    new DoubleTag('', $owner->getDirectionVector()->getX()),
                    new DoubleTag('', $owner->getDirectionVector()->getY()),
                    new DoubleTag('', $owner->getDirectionVector()->getZ())
                ]),
                'Rotation' => new ListTag('Rotation', [
                    new FloatTag("", $owner->getYaw()),
                    new FloatTag("", $owner->getPitch())
                ]),
            ]);
        parent::__construct($level, $scheduler, $nbt);
    }

    /**
     * @return Player
     */
    public function getOwner() : Player {
        return $this->owner;
    }
}