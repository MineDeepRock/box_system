<?php


namespace box_system\interpreters;


use box_system\models\MedicineBox;
use box_system\clients\MedicineBoxClient;
use box_system\pmmp\entities\BoxEntity;
use box_system\pmmp\events\MedicineBoxEffectOnEvent;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class MedicineBoxInterpreter extends BoxInterpreter
{
    private $client;
    private $scheduler;
    private $handler;

    function __construct(
        Player $player,
        TaskScheduler $scheduler) {
        $this->client = new MedicineBoxClient();
        $this->scheduler = $scheduler;

        $this->owner = $player;

        parent::__construct($player, new MedicineBox());
    }

    public function carryOut(BoxEntity $medicineBoxEntity): void {
        $this->handler = $this->scheduler->scheduleDelayedRepeatingTask(new ClosureTask(function (int $tick) use ($medicineBoxEntity): void {
            if (!$this->owner->isOnline()) {
                $this->stop();
            } else {
                $this->client->summonParticle(
                    $this->owner->getLevel(),
                    $medicineBoxEntity->getPosition());
                foreach ($this->getWithinRangePlayers($medicineBoxEntity->getPosition()) as $player) {
                    $event = new MedicineBoxEffectOnEvent($this->owner, $player);
                    $event->call();
                }
            }
        }), 20 * 2, 20 * 5);
    }

    public function stop(): void {
        $this->handler->cancel();
    }
}