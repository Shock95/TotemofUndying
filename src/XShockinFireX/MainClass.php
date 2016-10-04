<?php
namespace XShockinFireX;

use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\entity\Effect;
use pocketmine\item\Item;
use pocketmine\event\entity\EntityDamageEvent;

class MainClass extends PluginBase implements Listener {

	public function onEnable() {
		$this->getLogger()->info(TextFormat::GREEN . "Totem of Undying by XShockinFireX has been enabled.");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
	}

	public function onEntityDamage(EntityDamageEvent $event) {
        $entity = $event->getEntity();
		if($entity instanceof Player) {
		    if($entity->getInventory()->getItemInHand()->getId() == $this->getConfig()->get("totem-id")) {
                if($event->getCause() === EntityDamageEvent::CAUSE_VOID || $event->getCause() === EntityDamageEvent::CAUSE_SUICIDE) return false;
            	if($event->getDamage() >= $entity->getHealth()) {
                    $entity->getInventory()->removeItem(Item::get($entity->getInventory()->getItemInHand()->getId(), 0, 1));
            	    $event->setCancelled();
            	    $entity->getHealth($entity->setHealth() + 2);
            	    $entity->addEffect(Effect::getEffect(10)->setAmplifier(1)->setDuration(800)->setVisible(true));
            	    $entity->addEffect(Effect::getEffect(22)->setAmplifier(1)->setDuration(100)->setVisible(true));
            	    $entity->sendTip(TextFormat::GOLD . "Your Totem of Undying has saved you from dying!\n\n\n\n\n\n\n\n");
            	}
            }
        }
    }
}
