<?php


namespace box_system\interpreters;


use box_system\controllers\EventController;
use box_system\models\AmmoBox;
use box_system\pmmp\clients\AmmoBoxClient;
use box_system\pmmp\entities\BoxEntity;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class AmmoBoxInterpreter extends BoxInterpreter
{
    private $client;
    private $scheduler;
    private $handler;

    function __construct(
        Player $player,
        TaskScheduler $scheduler) {
        $this->client = new AmmoBoxClient();
        $this->scheduler = $scheduler;

        parent::__construct($player,new AmmoBox());
    }

    public function carryOut(BoxEntity $ammoBoxEntity) :void {
        $this->handler = $this->scheduler->scheduleDelayedRepeatingTask(new ClosureTask(function (int $tick) use ($ammoBoxEntity): void {
            if (!$this->owner->isOnline()) {
                $this->stop();
            } else {
                $this->client->summonParticle(
                    $this->owner->getLevel(),
                    $ammoBoxEntity->getPosition());
                foreach ($this->getWithinRangePlayers($ammoBoxEntity->getPosition()) as $player) {
                    EventController::getInstance()->callAmmoBoxEffectOnEvent($this->owner,$player);
                }
            }
        }), 20 * 2, 20 * 5);
    }

    public function stop(): void {
        $this->handler->cancel();
    }
}