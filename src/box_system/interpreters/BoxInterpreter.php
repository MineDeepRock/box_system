<?php


namespace box_system\interpreters;


use box_system\models\Box;
use box_system\pmmp\entities\BoxEntity;
use pocketmine\math\Vector3;
use pocketmine\Player;

abstract class BoxInterpreter
{
    protected $owner;
    protected $box;

    public function __construct(Player $owner, Box $box) {
        $this->owner = $owner;
        $this->box = $box;
    }

    /**
     * @return Player
     */
    public function getOwner(): Player {
        return $this->owner;
    }

    protected function getWithinRangePlayers(Vector3 $pos): array {
        if ($this->owner->getLevel() === null) return [];

        $players = $this->owner->getLevel()->getPlayers();
        return array_filter($players, function ($player) use ($pos) {
            return $pos->distance($player->getPosition()) <= $this->box::RANGE;
        });
    }

    abstract public function carryOut(BoxEntity $entity): void;
}