<?php


namespace box_system\pmmp\entities;


use box_system\interpreters\FlareBoxInterpreter;
use box_system\models\FlareBox;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class FlareBoxEntity extends BoxEntity
{
    public $skinName = "FlareBox";
    public $geometryId = "geometry.FlareBox";
    public $geometryName = "FlareBox.geo.json";

    private $interpreter;
    private $handler;

    public function __construct(
        Level $level,
        Player $owner,
        TaskScheduler $scheduler) {
        parent::__construct($level, $owner, $scheduler);
        $this->setMotion($this->getMotion()->multiply(1.5));

        $this->interpreter = new FlareBoxInterpreter(
            $owner,
            $scheduler);

        $this->interpreter->carryOut($this);

        $this->handler = $scheduler->scheduleDelayedTask(new ClosureTask(function (int $tick): void {
            if ($this->isAlive()) $this->kill();
        }), 20 * FlareBox::SECOND_LIMIT);
    }

    protected function onDeath(): void {
        $this->handler->cancel();
        $this->interpreter->stop();
        parent::onDeath();
    }

    public function getName(): string {
        return "FlareBox";
    }
}