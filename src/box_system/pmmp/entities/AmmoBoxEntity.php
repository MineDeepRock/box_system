<?php


namespace box_system\pmmp\entities;


use box_system\interpreters\AmmoBoxInterpreter;
use box_system\models\AmmoBox;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class AmmoBoxEntity extends BoxEntity
{
    public $skinName = "AmmoBox";
    public $geometryId = "geometry.AmmoBox";
    public $geometryName = "AmmoBox.geo.json";

    private $interpreter;
    private $handler;

    public function __construct(
        Level $level,
        Player $owner,
        TaskScheduler $scheduler) {
        parent::__construct($level, $owner, $scheduler);
        $this->interpreter = new AmmoBoxInterpreter(
            $owner,
            $scheduler);

        $this->interpreter->carryOut($this);

        $this->handler = $scheduler->scheduleDelayedTask(new ClosureTask(function (int $tick): void {
            if ($this->isAlive()) $this->kill();
        }), 20 * AmmoBox::SECOND_LIMIT);
    }

    protected function onDeath(): void {
        $this->handler->cancel();
        $this->interpreter->stop();
        parent::onDeath();
    }

    public function getName(): string {
        return "AmmoBox";
    }
}