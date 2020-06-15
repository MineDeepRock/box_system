<?php


namespace box_system\clients;


use pocketmine\level\Level;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\math\Vector3;

class AmmoBoxClient
{
    public function summonParticle(Level $level, Vector3 $pos) {
        for ($i = 0; $i < 6; ++$i) {
            $level->addParticle(new HappyVillagerParticle(
                new Vector3(
                    $pos->getX() + rand(-3, 3),
                    $pos->getY() + rand(0, 3),
                    $pos->getZ() + rand(-3, 3))
            ));
        }
    }
}