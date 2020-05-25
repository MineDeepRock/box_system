<?php


use box_system\pmmp\entities\AmmoBoxEntity;
use box_system\pmmp\entities\FlareBoxEntity;
use box_system\pmmp\entities\MedicineBoxEntity;
use box_system\pmmp\events\AmmoBoxEffectOnEvent;
use box_system\pmmp\events\FlareBoxEffectOnEvent;
use box_system\pmmp\events\MedicineBoxEffectOnEvent;
use box_system\pmmp\items\SpawnAmmoBoxItem;
use box_system\pmmp\items\SpawnFlareBoxItem;
use box_system\pmmp\items\SpawnMedicineBoxItem;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class BoxListener implements Listener
{
    private $plugin;

    public function __construct(PluginBase $plugin) {
        $this->plugin = $plugin;
    }

    public function onTapByItem(PlayerInteractEvent $event) {
        if ($event->getAction() !== PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
            $player = $event->getPlayer();
            $item = $player->getInventory()->getItemInHand();
            switch ($item->getId()) {
                case SpawnAmmoBoxItem::ITEM_ID:
                    $this->spawnAmmoBox($player);
                    break;
                case SpawnMedicineBoxItem::ITEM_ID:
                    $this->spawnMedicineBox($player);
                    break;
                case SpawnFlareBoxItem::ITEM_ID:
                    $this->spawnFlareBox($player);
                    break;
            }
        }
    }
    public function onTapByForTapUser(DataPacketReceiveEvent $event) {
        $packet = $event->getPacket();
        if ($packet instanceof LevelSoundEventPacket) {
            if ($packet->sound === LevelSoundEventPacket::SOUND_ATTACK_NODAMAGE) {
                $player = $event->getPlayer();
                $item = $event->getPlayer()->getInventory()->getItemInHand();
                switch ($item->getId()) {
                    case SpawnAmmoBoxItem::ITEM_ID:
                        $this->spawnAmmoBox($player);
                        break;
                    case SpawnMedicineBoxItem::ITEM_ID:
                        $this->spawnMedicineBox($player);
                        break;
                    case SpawnFlareBoxItem::ITEM_ID:
                        $this->spawnFlareBox($player);
                        break;
                }
            }
        }
    }

    public function spawnAmmoBox(Player $player) {
        $player->getInventory()->remove(new SpawnAmmoBoxItem());

        $ammoBox = new AmmoBoxEntity(
            $player->getLevel(),
            $player,
            $this->plugin->getScheduler());
        $ammoBox->spawnToAll();
    }

    public function spawnMedicineBox(Player $player) {
        $player->getInventory()->remove(new SpawnMedicineBoxItem());
        $medicineBox = new MedicineBoxEntity(
            $player->getLevel(),
            $player,
            $this->plugin->getScheduler());
        $medicineBox->spawnToAll();
    }

    public function spawnFlareBox(Player $player) {
        $player->getInventory()->remove(new SpawnFlareBoxItem());

        $flareBox = new FlareBoxEntity(
            $player->getLevel(),
            $player,
            $this->plugin->getScheduler());

        $flareBox->spawnToAll();
    }
}