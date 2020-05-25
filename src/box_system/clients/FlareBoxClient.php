<?php


namespace game_system\pmmp\client;


use pocketmine\level\Level;
use pocketmine\level\particle\AngryVillagerParticle;
use pocketmine\math\Vector3;
use pocketmine\Player;

class FlareBoxClient
{
    public function summonParticle(Level $level, Vector3 $pos) {
        for ($i = 0; $i < 6; ++$i) {
            $level->addParticle(new AngryVillagerParticle(
                new Vector3(
                    $pos->getX() + rand(-3, 3),
                    $pos->getY() + rand(0, 3),
                    $pos->getZ() + rand(-3, 3))
            ));
        }
    }
}