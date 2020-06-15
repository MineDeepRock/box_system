<?php


namespace box_system\interpreters;


use box_system\models\FlareBox;
use box_system\pmmp\entities\BoxEntity;
use box_system\pmmp\events\FlareBoxEffectOnEvent;
use game_system\client\FlareBoxClient;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class FlareBoxInterpreter extends BoxInterpreter
{
    private $client;
    private $scheduler;
    private $handler;

    function __construct(
        Player $player,
        TaskScheduler $scheduler) {
        $this->client = new FlareBoxClient();
        $this->scheduler = $scheduler;

        parent::__construct($player, new FlareBox());
    }

    public function carryOut(BoxEntity $flareBoxEntity): void {
        $this->handler = $this->scheduler->scheduleDelayedRepeatingTask(new ClosureTask(function (int $tick) use ($flareBoxEntity): void {
            if (!$this->owner->isOnline()) {
                $this->stop();
            } else {
                $this->client->summonParticle(
                    $this->owner->getLevel(),
                    $flareBoxEntity->getPosition());
                foreach ($this->getWithinRangePlayers($flareBoxEntity->getPosition()) as $player) {
                    $event = new FlareBoxEffectOnEvent($this->owner, $player);
                    $event->call();
                }
            }
        }), 20 * 2, 20 * 5);
    }

    public function stop(): void {
        $this->handler->cancel();
    }
}