<?php

namespace Gelu;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\entity\EntityDamageEvent;

use pocketmine\world\particle\FlameParticle;

use pocketmine\math\Vector3;


class main extends PluginBase implements Listener{
  public function onEnable(): void {
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
   public $noDamage = [];
  
   public function onMove(PlayerMoveEvent $event){
    $player = $event->getPlayer();
    $world = $player->getWorld();
    $x = $player->getPosition()->getX();
    $y = $player->getPosition()->getY();
    $z = $player->getPosition()->getZ();
    $block = $player->getWorld()->getBlock(new Vector3($x, $y - 0.5, $z));
    if($block->getId() === 165){
        $this->noDamage[$player->getName()] = $player->getName();
         $player->setMotion(new Vector3(0, 0.8, 0));
         $world->addParticle(new Vector3($x, $y, $z), new FlameParticle());
         $world->addParticle(new Vector3($x, $y, $z), new FlameParticle());
         $world->addParticle(new Vector3($x, $y, $z), new FlameParticle());
         $world->addParticle(new Vector3($x, $y, $z), new FlameParticle());
    }
   }
       public function onDamage(EntityDamageEvent $event){
      if($event->getEntity() instanceof Player){
  if($event->getCause() == EntityDamageEvent::CAUSE_FALL){
    if(isset($this->noDamage[$event->getEntity()->getName()])){
     $event->cancel();
          unset($this->noDamage[$event->getEntity()->getName()]);
  }
 }
     }
   }
}
