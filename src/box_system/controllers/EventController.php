<?php

namespace box_system\controllers;

use box_system\pmmp\events\AmmoBoxEffectOnEvent;
use box_system\pmmp\events\FlareBoxEffectOnEvent;
use box_system\pmmp\events\MedicineBoxEffectOnEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class EventController
{
    private static $instance;
    private $plugin;

    public function __construct(PluginBase $plugin) {
        $this->plugin = $plugin;
        self::$instance = $this;
    }

    /**
     * @return EventController
     */
    public static function getInstance(): EventController {
        return self::$instance;
    }

    public function callAmmoBoxEffectOnEvent(Player $owner, Player $receiver): void {
        $event = new AmmoBoxEffectOnEvent($this->plugin, $owner, $receiver);
        $event->call();
    }

    public function callMedicineBoxEffectOnEvent(Player $owner, Player $receiver): void {
        $event = new MedicineBoxEffectOnEvent($this->plugin, $owner, $receiver);
        $event->call();
    }

    public function callFlareBoxEffectOnEvent(Player $owner, Player $receiver): void {
        $event = new FlareBoxEffectOnEvent($this->plugin, $owner, $receiver);
        $event->call();
    }
}