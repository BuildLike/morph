<?php

namespace morph;

use morph\entity\Morph;
use morph\entity\MorphBat;
use morph\entity\MorphBlaze;
use morph\entity\MorphCaveSpider;
use morph\entity\MorphChicken;
use morph\entity\MorphCow;
use morph\entity\MorphCreeper;
use morph\entity\MorphDonkey;
use morph\entity\MorphElderGuardian;
use morph\entity\MorphEnderDragon;
use morph\entity\MorphEnderman;
use morph\entity\MorphEndermite;
use morph\entity\MorphGhast;
use morph\entity\MorphGuardian;
use morph\entity\MorphHorse;
use morph\entity\MorphHusk;
use morph\entity\MorphIronGolem;
use morph\entity\MorphMagmaCube;
use morph\entity\MorphMooshroom;
use morph\entity\MorphMule;
use morph\entity\MorphOcelot;
use morph\entity\MorphPig;
use morph\entity\MorphPigZombie;
use morph\entity\MorphPolarBear;
use morph\entity\MorphRabbit;
use morph\entity\MorphSheep;
use morph\entity\MorphShulker;
use morph\entity\MorphSilverfish;
use morph\entity\MorphSkeleton;
use morph\entity\MorphSkeletonHorse;
use morph\entity\MorphSlime;
use morph\entity\MorphSnowman;
use morph\entity\MorphSpider;
use morph\entity\MorphSquid;
use morph\entity\MorphStray;
use morph\entity\MorphVillager;
use morph\entity\MorphWitch;
use morph\entity\MorphWither;
use morph\entity\MorphWitherSkeleton;
use morph\entity\MorphWolf;
use morph\entity\MorphZombie;
use morph\entity\MorphZombieHorse;
use morph\entity\MorphZombieVillager;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Effect;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

class main extends PluginBase implements Listener
{
    public $id;
    public $eid;
    public $owner;

    public function onEnable()
    {
        Entity::registerEntity(MorphCreeper::class, true);
        Entity::registerEntity(MorphBat::class, true);
        Entity::registerEntity(MorphSheep::class, true);
        Entity::registerEntity(MorphPigZombie::class, true);
        Entity::registerEntity(MorphGhast::class, true);
        Entity::registerEntity(MorphBlaze::class, true);
        Entity::registerEntity(MorphIronGolem::class, true);
        Entity::registerEntity(MorphSnowman::class, true);
        Entity::registerEntity(MorphOcelot::class, true);
        Entity::registerEntity(MorphZombieVillager::class, true);
        Entity::registerEntity(MorphVillager::class, true);
        Entity::registerEntity(MorphZombie::class, true);
        Entity::registerEntity(MorphSquid::class, true);
        Entity::registerEntity(MorphCow::class, true);
        Entity::registerEntity(MorphSpider::class, true);
        Entity::registerEntity(MorphPig::class, true);
        Entity::registerEntity(MorphMooshroom::class, true);
        Entity::registerEntity(MorphWolf::class, true);
        Entity::registerEntity(MorphMagmaCube::class, true);
        Entity::registerEntity(MorphSilverfish::class, true);
        Entity::registerEntity(MorphSkeleton::class, true);
        Entity::registerEntity(MorphSlime::class, true);
        Entity::registerEntity(MorphChicken::class, true);
        Entity::registerEntity(MorphEnderman::class, true);
        Entity::registerEntity(MorphCaveSpider::class, true);
        Entity::registerEntity(MorphPolarBear::class, true);
        Entity::registerEntity(MorphDonkey::class, true);
        Entity::registerEntity(MorphMule::class, true);
        Entity::registerEntity(MorphSkeletonHorse::class, true);
        Entity::registerEntity(MorphZombieHorse::class, true);
        Entity::registerEntity(MorphRabbit::class, true);
        Entity::registerEntity(MorphWitch::class, true);
        Entity::registerEntity(MorphStray::class, true);
        Entity::registerEntity(MorphHusk::class, true);
        Entity::registerEntity(MorphWitherSkeleton::class, true);
        Entity::registerEntity(MorphGuardian::class, true);
        Entity::registerEntity(MorphElderGuardian::class, true);
        Entity::registerEntity(MorphWither::class, true);
        Entity::registerEntity(MorphEnderDragon::class, true);
        Entity::registerEntity(MorphShulker::class, true);
        Entity::registerEntity(MorphEndermite::class, true);
        Entity::registerEntity(MorphHorse::class, true);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    public function createNbt($x, $y, $z, $yaw, $pitch)
    {
        $nbt = new CompoundTag;
        $nbt->Pos = new ListTag("Pos", [
            new DoubleTag("", $x),
            new DoubleTag("", $y),
            new DoubleTag("", $z)
        ]);
        $nbt->Rotation = new ListTag("Rotation", [
            new FloatTag("", $yaw),
            new FloatTag("", $pitch)
        ]);
        $nbt->Health = new ShortTag("Health", 1);
        $nbt->Invulnerable = new ByteTag("Invulnerable", 1);
        return $nbt;
    }

    public function spawn(Player $player, $name)
    {
        $entity = Entity::createEntity($name, $player->getLevel(), $this->createNbt($player->x, $player->y, $player->z, $player->yaw, $player->pitch));
        $entity->spawnToAll();
        $this->eid[$player->getName()] = $entity->getId();
        $entity->setNameTag($player->getName());
        $entity->setNameTagAlwaysVisible(true);
        $entity->setNameTagVisible(true);
        foreach ($this->getServer()->getOnlinePlayers() as $pl) {
            $pl->hidePlayer($player);
        }
        $player->addEffect(Effect::getEffect(14)->setDuration(9999999999)->setVisible(false));
    }

    public function moveEntity(Player $player, $entityId)
    {
        $chunk = $player->getLevel()->getChunk($player->x >> 4, $player->z >> 4);
        $player->getLevel()->addEntityMovement(
            $chunk->getX(), $chunk->getZ(),
            $entityId,
            $player->x, $player->y, $player->z,
            $player->yaw, $player->pitch
        );
    }

    public function removeMob(Player $p)
    {
        if (isset($this->eid[$p->getName()])) {
            $p->getLevel()->getEntity($this->eid[$p->getName()])->kill();
            unset($this->eid[$p->getName()]);
            foreach ($this->getServer()->getOnlinePlayers() as $pl) {
                $pl->showPlayer($p);
            }
        }
    }

    //EVENTS
    public function respawn(PlayerRespawnEvent $e)
    {
        $e->getPlayer()->removeAllEffects();
    }

    public function onExit(PlayerQuitEvent $e)
    {
        $this->removeMob($e->getPlayer());
    }

    public function onDeath(PlayerDeathEvent $e)
    {
        $this->removeMob($e->getPlayer());
    }

    public function move(PlayerMoveEvent $e)
    {
        if (isset($this->eid[$e->getPlayer()->getName()])) {
            $this->moveEntity($e->getPlayer(), $this->eid[$e->getPlayer()->getName()]);
        }
    }

    public function noDmg(EntityDamageEvent $e)
    {
        if ($e instanceof EntityDamageByEntityEvent) {
            $damager = $e->getDamager();
            $entity = $e->getEntity();
            if ($damager instanceof Player && $entity instanceof Morph) {
                $e->setCancelled();
            }
        }
    }

    //COMMANDS
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args)
    {
        $cmds = new Commands($this);
        $cmds->onCommand($sender, $cmd, $args);
    }

    //lang API
    public function getLang()
    {
        return $this->getConfig()->get("lang");
    }

}