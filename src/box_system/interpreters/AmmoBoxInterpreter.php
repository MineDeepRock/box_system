<?php


namespace box_system\interpreters;


use box_system\models\AmmoBox;
use box_system\clients\AmmoBoxClient;
use box_system\pmmp\entities\BoxEntity;
use box_system\pmmp\events\AmmoBoxEffectOnEvent;
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
                    $event = new AmmoBoxEffectOnEvent($this->owner, $player);
                    $event->call();
                }
            }
        }), 20 * 2, 20 * 5);
    }

    public function stop(): void {
        $this->handler->cancel();
    }
}