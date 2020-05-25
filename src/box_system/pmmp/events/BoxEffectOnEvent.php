<?php

namespace box_system\pmmp\events;

use pocketmine\event\plugin\PluginEvent;
use pocketmine\plugin\Plugin;

class BoxEffectOnEvent extends PluginEvent{
    public function __construct(Plugin $plugin) {
        parent::__construct($plugin);
    }
}