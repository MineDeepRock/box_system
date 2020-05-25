<?php


namespace box_system\pmmp\entities;


use box_system\interpreters\MedicineBoxInterpreter;
use box_system\models\MedicineBox;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;

class MedicineBoxEntity extends BoxEntity
{
    public $skinName = "MedicineBox";
    public $geometryId = "geometry.MedicineBox";
    public $geometryName = "MedicineBox.geo.json";

    private $interpreter;
    private $handler;

    public function __construct(
        Level $level,
        Player $owner,
        TaskScheduler $scheduler) {
        parent::__construct($level, $owner, $scheduler);
        $this->interpreter = new MedicineBoxInterpreter(
            $owner,
            $scheduler);

        $this->interpreter->carryOut($this);

        $this->handler = $scheduler->scheduleDelayedTask(new ClosureTask(function (int $tick): void {
            if ($this->isAlive()) $this->kill();
        }), 20 * MedicineBox::SECOND_LIMIT);
    }

    protected function onDeath(): void {
        $this->interpreter->stop();
        $this->handler->cancel();
        parent::onDeath();
    }

    public function getName(): string {
        return "MedicineBox";
    }
}