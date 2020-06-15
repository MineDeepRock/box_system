<?php


namespace box_system\pmmp\events;


use box_system\models\Box;
use pocketmine\event\Event;
use pocketmine\Player;

class BoxStopEvent extends Event
{
    /**
     * @var Player
     */
    private $owner;
    /**
     * @var Box
     */
    private $box;

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

    /**
     * @return Box
     */
    public function getBox(): Box {
        return $this->box;
    }
}