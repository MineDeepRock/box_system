<?php

namespace box_system\pmmp\events;

use pocketmine\Player;
use pocketmine\plugin\Plugin;

class AmmoBoxEffectOnEvent extends BoxEffectOnEvent
{
    private $owner;
    private $receiver;

    public function __construct(Player $owner, Player $receiver) {
        $this->owner = $owner;
        $this->receiver = $receiver;
    }

    /**
     * @return Player
     */
    public function getOwner(): Player {
        return $this->owner;
    }

    /**
     * @return Player
     */
    public function getReceiver(): Player {
        return $this->receiver;
    }
}