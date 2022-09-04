<?php

namespace Kuu\Arena;

use Kuu\Core;
use Kuu\utils\FormAPI\SimpleForm;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\item\{VanillaItems};
use pocketmine\item\enchantment\{EnchantmentInstance, VanillaEnchantments};
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as Color;

class Arena
{

    public function getForm(Player $player): void
    {
        $form = new SimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    $this->onJoinGapple($player);
                    break;
                case 1:
                    $this->onJoinCombo($player);
                    break;
                case 2:
                    $this->onJoinNodebuff($player);
                    break;
                case 3:
                    $this->onJoinFist($player);
                    break;
                case 4:
                    $this->onJoinResistance($player);
                    break;
            }
            return true;
        });
        $gapple = "§eCurrently Playing§0:§b " . $this->getPlayers(Core::getCreator()->getGappleArena());
        $combo = "§eCurrently Playing§0:§b " . $this->getPlayers(Core::getCreator()->getComboArena());
        $Nodebuff = "§eCurrently Playing§0:§b " . $this->getPlayers(Core::getCreator()->getNodebuffArena());
        $fist = "§eCurrently Playing§0:§b " . $this->getPlayers(Core::getCreator()->getFistArena());
        $resis = "§eCurrently Playing§0:§b " . $this->getPlayers(Core::getCreator()->getResistanceArena());
        $form->setTitle(Core::getPluginName() . " §ePractice Core");
        $form->addButton("§6Gapple\n" . $gapple, 0, "textures/items/apple_golden.png");
        $form->addButton("§6Combo\n" . $combo, 0, "textures/items/feather.png");
        $form->addButton("§6Nodebuff\n" . $Nodebuff, 0, "textures/items/potion_bottle_splash_saturation.png");
        $form->addButton("§6Fist\n" . $fist, 0, "textures/items/beef_cooked.png");
        $form->addButton("§6Resistance\n" . $resis, 0, "textures/items/snowball.png");
        $form->sendToPlayer($player);
    }

    public function onJoinGapple(Player $player): void
    {
        $world = Core::getCreator()->getGappleArena();
        $x = Core::getCreator()->getGappleSpawn();
        if ($world !== null) {
            Server::getInstance()->getWorldManager()->loadWorld($world);
            $player->setGamemode(Gamemode::ADVENTURE());
            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();
            $player->getEffects()->clear();
            $player->setAllowFlight(false);
            $player->setFlying(false);
            $player->setHealth(20);
            $player->getHungerManager()->setFood(20);
            $player->setScale(1);
            $this->getKitGapple($player);
            $player->teleport(Server::getInstance()->getWorldManager()->getWorldByName($world)?->getSafeSpawn());
            $player->teleport(new Vector3($x[0], $x[1] + 0.6, $x[2]));
            Core::getCoreUtils()->playSound($player, 'jump.slime');
        } else {
            $player->sendMessage(Core::getPrefix() . "Arena not available");
        }
    }

    public function getKitGapple(Player $player): void
    {
        $inventory = $player->getInventory();
        $armorInventory = $player->getArmorInventory();
        $protection = VanillaEnchantments::PROTECTION();
        $unbreaking = VanillaEnchantments::UNBREAKING();
        $helmet = VanillaItems::DIAMOND_HELMET();
        $helmet->addEnchantment(new EnchantmentInstance($protection));
        $helmet->addEnchantment(new EnchantmentInstance($unbreaking));
        $chestplate = VanillaItems::DIAMOND_CHESTPLATE();
        $chestplate->addEnchantment(new EnchantmentInstance($protection));
        $chestplate->addEnchantment(new EnchantmentInstance($unbreaking));
        $leggings = VanillaItems::DIAMOND_LEGGINGS();
        $leggings->addEnchantment(new EnchantmentInstance($protection));
        $leggings->addEnchantment(new EnchantmentInstance($unbreaking));
        $boots = VanillaItems::DIAMOND_BOOTS();
        $boots->addEnchantment(new EnchantmentInstance($protection));
        $boots->addEnchantment(new EnchantmentInstance($unbreaking));
        $armorInventory->setHelmet($helmet);
        $armorInventory->setBoots($boots);
        $armorInventory->setChestplate($chestplate);
        $armorInventory->setLeggings($leggings);
        $sword = VanillaItems::DIAMOND_SWORD();
        $sword->addEnchantment((new EnchantmentInstance($unbreaking, 2)));
        $inventory->addItem($sword);
        $inventory->addItem(VanillaItems::GOLDEN_APPLE()->setCount(16));
    }

    public function onJoinCombo(Player $player): void
    {
        $world = Core::getCreator()->getComboArena();
        $x = Core::getCreator()->getComboSpawn();
        if ($world !== null) {
            Server::getInstance()->getWorldManager()->loadWorld($world);
            $player->setGamemode(Gamemode::ADVENTURE());
            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();
            $player->getEffects()->clear();
            $player->setAllowFlight(false);
            $player->setFlying(false);
            $player->setHealth(20);
            $player->getHungerManager()->setFood(20);
            $player->setScale(1);
            $this->getKitCombo($player);
            $player->teleport(Server::getInstance()->getWorldManager()->getWorldByName($world)?->getSafeSpawn());
            $player->teleport(new Vector3($x[0], $x[1] + 0.6, $x[2]));
            Core::getCoreUtils()->playSound($player, 'jump.slime');
        } else {
            $player->sendMessage(Core::getPrefix() . "Arena not available");
        }
    }

    public function getKitCombo(Player $player): void
    {
        $inventory = $player->getInventory();
        $armorInventory = $player->getArmorInventory();
        $protection = VanillaEnchantments::PROTECTION();
        $unbreaking = VanillaEnchantments::UNBREAKING();
        $helmet = VanillaItems::DIAMOND_HELMET();
        $helmet->addEnchantment(new EnchantmentInstance($protection));
        $helmet->addEnchantment(new EnchantmentInstance($unbreaking));
        $chestplate = VanillaItems::DIAMOND_CHESTPLATE();
        $chestplate->addEnchantment(new EnchantmentInstance($protection));
        $chestplate->addEnchantment(new EnchantmentInstance($unbreaking));
        $leggings = VanillaItems::DIAMOND_LEGGINGS();
        $leggings->addEnchantment(new EnchantmentInstance($protection));
        $leggings->addEnchantment(new EnchantmentInstance($unbreaking));
        $boots = VanillaItems::DIAMOND_BOOTS();
        $boots->addEnchantment(new EnchantmentInstance($protection));
        $boots->addEnchantment(new EnchantmentInstance($unbreaking));
        $armorInventory->setHelmet($helmet);
        $armorInventory->setBoots($boots);
        $armorInventory->setChestplate($chestplate);
        $armorInventory->setLeggings($leggings);
        $sharpness = VanillaEnchantments::SHARPNESS();
        $sword = VanillaItems::DIAMOND_SWORD();
        $sword->addEnchantment(new EnchantmentInstance($sharpness, 2));
        $inventory->addItem($sword);
        $inventory->addItem(VanillaItems::ENCHANTED_GOLDEN_APPLE()->setCount(8));
    }

    public function onJoinNodebuff(Player $player): void
    {
        $world = Core::getCreator()->getNodebuffArena();
        $x = Core::getCreator()->getNodebuffSpawn();
        if ($world !== null) {
            Server::getInstance()->getWorldManager()->loadWorld($world);
            $player->setGamemode(Gamemode::ADVENTURE());
            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();
            $player->getEffects()->clear();
            $player->setAllowFlight(false);
            $player->setFlying(false);
            $player->setHealth(20);
            $player->getHungerManager()->setFood(20);
            $player->setScale(1);
            $this->getKitNodebuff($player);
            $player->teleport(Server::getInstance()->getWorldManager()->getWorldByName($world)?->getSafeSpawn());
            $player->teleport(new Vector3($x[0], $x[1] + 0.6, $x[2]));
            Core::getCoreUtils()->playSound($player, 'jump.slime');
        } else {
            $player->sendMessage(Core::getPrefix() . "Arena not available");
        }
    }

    public function getKitNodebuff(Player $player): void
    {

        $inventory = $player->getInventory();
        $armorInventory = $player->getArmorInventory();
        $protection = VanillaEnchantments::PROTECTION();
        $unbreaking = VanillaEnchantments::UNBREAKING();
        $helmet = VanillaItems::DIAMOND_HELMET();
        $helmet->addEnchantment(new EnchantmentInstance($protection));
        $helmet->addEnchantment(new EnchantmentInstance($unbreaking));
        $chestplate = VanillaItems::DIAMOND_CHESTPLATE();
        $chestplate->addEnchantment(new EnchantmentInstance($protection));
        $chestplate->addEnchantment(new EnchantmentInstance($unbreaking));
        $leggings = VanillaItems::DIAMOND_LEGGINGS();
        $leggings->addEnchantment(new EnchantmentInstance($protection));
        $leggings->addEnchantment(new EnchantmentInstance($unbreaking));
        $boots = VanillaItems::DIAMOND_BOOTS();
        $boots->addEnchantment(new EnchantmentInstance($protection));
        $boots->addEnchantment(new EnchantmentInstance($unbreaking));
        $armorInventory->setHelmet($helmet);
        $armorInventory->setBoots($boots);
        $armorInventory->setChestplate($chestplate);
        $armorInventory->setLeggings($leggings);
        $sword = VanillaItems::DIAMOND_SWORD();
        $sword->addEnchantment(new EnchantmentInstance($unbreaking, 2));
        $inventory->addItem($sword);
        $inventory->addItem(VanillaItems::ENDER_PEARL()->setCount(16));
        $inventory->addItem(VanillaItems::STRONG_HEALING_SPLASH_POTION()->setCount(31));
        $inventory->addItem(VanillaItems::SWIFTNESS_SPLASH_POTION()->setCount(1));
    }

    public function onJoinFist(Player $player): void
    {
        $world = Core::getCreator()->getFistArena();
        $x = Core::getCreator()->getFistSpawn();
        if ($world !== null) {
            Server::getInstance()->getWorldManager()->loadWorld($world);
            $player->setGamemode(Gamemode::ADVENTURE());
            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();
            $player->getEffects()->clear();
            $player->setAllowFlight(false);
            $player->setFlying(false);
            $player->setMaxHealth(20);
            $player->setHealth(20);
            $player->getHungerManager()->setFood(20);
            $player->setScale(1);
            $this->getKitFist($player);
            $player->teleport(Server::getInstance()->getWorldManager()->getWorldByName($world)?->getSafeSpawn());
            $player->teleport(new Vector3($x[0], $x[1] + 0.6, $x[2]));
            Core::getCoreUtils()->playSound($player, 'jump.slime');
        } else {
            $player->sendMessage(Core::getPrefix() . "Arena not available");
        }
    }

    public function getKitFist(Player $player): void
    {
        $inventory = $player->getInventory();
        $inventory->addItem(VanillaItems::STEAK()->setCount(16));
    }

    public function onJoinResistance(Player $player): void
    {
        $world = Core::getCreator()->getResistanceArena();
        $x = Core::getCreator()->getResistanceSpawn();
        if ($world !== null) {
            Server::getInstance()->getWorldManager()->loadWorld($world);
            $player->setGamemode(Gamemode::ADVENTURE());
            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();
            $player->getEffects()->clear();
            $player->setAllowFlight(false);
            $player->setFlying(false);
            $player->setHealth(20);
            $player->getHungerManager()->setFood(20);
            $player->setScale(1);
            $this->getKitResistance($player);
            $player->teleport(Server::getInstance()->getWorldManager()->getWorldByName($world)?->getSafeSpawn());
            $player->teleport(new Vector3($x[0], $x[1] + 0.6, $x[2]));
            Core::getCoreUtils()->playSound($player, 'jump.slime');
        } else {
            $player->sendMessage(Core::getPrefix() . "Arena not available");
        }
    }

    public function getKitResistance(Player $player): void
    {
        $inventory = $player->getInventory();
        $inventory->addItem(VanillaItems::STEAK()->setCount(16));
        $eff = new EffectInstance(VanillaEffects::RESISTANCE(), 4 * 999999, 255, true);
        $player->getEffects()->add($eff);
    }

    public function getPlayers(string $arena): int|string
    {
        if (!Server::getInstance()->getWorldManager()->getWorldByName($arena)) {
            return Color::DARK_RED . "Unloaded World";
        }
        return count(Server::getInstance()->getWorldManager()->getWorldByName($arena)->getPlayers());
    }

    public function getReKit(Player $player): void
    {
        if ($player->getWorld() === Server::getInstance()->getWorldManager()->getWorldByName(Core::getCreator()->getGappleArena())) {
            $player->getInventory()->addItem(VanillaItems::GOLDEN_APPLE()->setCount(1));
        } else if ($player->getWorld() === Server::getInstance()->getWorldManager()->getWorldByName(Core::getCreator()->getComboArena())) {
            $player->getInventory()->addItem(VanillaItems::ENCHANTED_GOLDEN_APPLE()->setCount(1));
        } else if ($player->getWorld() === Server::getInstance()->getWorldManager()->getWorldByName(Core::getCreator()->getNodebuffArena())) {
            $player->getInventory()->addItem(VanillaItems::STRONG_HEALING_SPLASH_POTION()->setCount(31));
            $player->getInventory()->addItem(VanillaItems::SWIFTNESS_SPLASH_POTION()->setCount(1));
        } else if ($player->getWorld() === Server::getInstance()->getWorldManager()->getWorldByName(Core::getCreator()->getFistArena())) {
            $player->getInventory()->addItem(VanillaItems::STEAK());
        } else if ($player->getWorld() === Server::getInstance()->getWorldManager()->getWorldByName(Core::getCreator()->getResistanceArena())) {
            $player->getInventory()->addItem(VanillaItems::STEAK());
        }
    }
}