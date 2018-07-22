<?php
declare(strict_types=1);

namespace BowSounds;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\level\sound\GenericSound;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDamage(EntityDamageEvent $event): void{
        $entity = $event->getEntity();
        if($event instanceof EntityDamageByEntityEvent){
            $damager = $event->getDamager();
            if($entity instanceof Player && $damager instanceof Player && $event->getCause() == $event::CAUSE_PROJECTILE){
                $damager->getLevel()->addSound(new DingSound($damager->asVector3()), [$damager]);
            }
        }
    }
}

class DingSound extends GenericSound{

    /**
     * ExpPickupSound constructor.
     *
     * @param Vector3 $pos
     * @param int     $pitch
     */
    public function __construct(Vector3 $pos, $pitch = 0){
        parent::__construct($pos, LevelEventPacket::EVENT_SOUND_ORB, $pitch);
    }
}