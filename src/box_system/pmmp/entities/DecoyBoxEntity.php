<?php


namespace box_system\pmmp\entities;



use box_system\models\AmmoBox;
use box_system\pmmp\events\BoxStopEvent;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class DecoyBoxEntity extends BoxEntity
{
    private $handler;
    public $defaultHP = 20;

    public function __construct(
        Level $level,
        Player $owner,
        TaskScheduler $scheduler) {


        parent::__construct($level, $owner, $scheduler);

        $this->handler = $scheduler->scheduleDelayedTask(new ClosureTask(function (int $tick): void {
            if ($this->isAlive()) $this->kill();
        }), 20 * AmmoBox::SECOND_LIMIT);
    }

    protected function onDeath(): void {
        $this->handler->cancel();
        $event = new BoxStopEvent($this->owner, new AmmoBox());
        $event->call();
        parent::onDeath();
    }

    public function getName(): string {
        return "DecoyBox";
    }


    protected function initSkin(): void {
        $this->setSkin($this->owner->getSkin());
    }
}