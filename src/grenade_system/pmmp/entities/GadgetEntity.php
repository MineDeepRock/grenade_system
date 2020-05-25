<?php


namespace grenade_system\pmmp\entities;


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

    protected $ownerName;

    public function __construct(Level $level, string $ownerName, TaskScheduler $scheduler, ?CompoundTag $nbt = null) {
        $this->ownerName = $ownerName;
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

    private function initSkin(): void {
        $this->setSkin(new Skin(
            $this->skinId,
            file_get_contents("./plugin_data/GrenadeSystem/skin/" . $this->skinName . ".skin"),
            $this->capeData,
            $this->geometryId,
            file_get_contents("./plugin_data/GrenadeSystem/models/" . $this->geometryName)
        ));
    }

    public function getName(): string {
        return "";
    }

    /**
     * @return string
     */
    public function getOwnerName(): string {
        return $this->ownerName;
    }
}