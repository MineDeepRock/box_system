<?php


namespace box_system\pmmp\entities;


use pocketmine\entity\Human;
use pocketmine\entity\Skin;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\scheduler\TaskScheduler;
use pocketmine\utils\UUID;

class GadgetEntity extends Human
{

    protected $skinId = "Standard_CustomSlim";
    protected $skinName = "";

    protected $capeData = "";

    protected $geometryId = "";
    protected $geometryName = "";

    public $width = 1;
    public $height = 1;
    public $eyeHeight = 1.5;

    protected $gravity = 0.08;
    protected $drag = 0.02;

    public $scale = 1.0;

    public $defaultHP = 1;
    public $uuid;

    protected $scheduler;

    public function __construct(Level $level, TaskScheduler $scheduler, ?CompoundTag $nbt = null) {
        $this->uuid = UUID::fromRandom();
        $this->scheduler = $scheduler;
        $this->initSkin();

        parent::__construct($level, $nbt);
        $this->setRotation($this->yaw, $this->pitch);
        $this->setNameTagAlwaysVisible(false);
        $this->sendSkin();
    }

    public function initEntity(): void {
        parent::initEntity();
        $this->setScale($this->scale);
        $this->setMaxHealth($this->defaultHP);
        $this->setHealth($this->getMaxHealth());
    }

    protected function initSkin(): void {
        $this->setSkin(new Skin(
            $this->skinId,
            file_get_contents("./plugin_data/BoxSystem/skin/" . $this->skinName . ".skin"),
            $this->capeData,
            $this->geometryId,
            file_get_contents("./plugin_data/BoxSystem/models/" . $this->geometryName)
        ));
    }

    public function getName(): string {
        return "";
    }
}