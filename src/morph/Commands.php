<?php

namespace morph;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Commands
{

    public $plugin;

    public function __construct(main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getPlugin()
    {
        return $this->plugin;
    }

    public function onCommand(CommandSender $sender, Command $cmd, array $args)
    {
        if ($sender instanceof Player) {
            switch ($cmd->getName()) {
                case "morph":
                    $mobs = array(
                        "Bat",
                        "Blaze",
                        "CaveSpider",
                        "Chicken",
                        "Cow",
                        "Creeper",
                        "Donkey",
                        "ElderGuardian",
                        "EnderDragon",
                        "Enderman",
                        "Endermite",
                        "Ghast",
                        "Guardian",
                        "Horse",
                        "Husk",
                        "IronGolem",
                        "MagmaCube",
                        "Mooshroom",
                        "Mule",
                        "Ocelot",
                        "Pig",
                        "PigZombie",
                        "PolarBear",
                        "Rabbit",
                        "Sheep",
                        "Shulker",
                        "Silverfish",
                        "Skeleton",
                        "SkeletonHorse",
                        "Slime",
                        "Snowman",
                        "Spider",
                        "Squid",
                        "Stray",
                        "Villager",
                        "Witch",
                        "Wither",
                        "WitherSkeleton",
                        "Wolf",
                        "Zombie",
                        "ZombieVillager",
                    );
                    if (isset($args[0]) && $args[0] == "add") {
                        if (isset($args[1])) {
                            if (in_array($args[1], $mobs)) {
                                $this->plugin->removeMob($sender);
                                $this->plugin->spawn($sender, "Morph" . $args[1]);
                            } else {
                                if ($this->plugin->getLang() == "rus") {
                                    $sender->sendMessage(TextFormat::GREEN . "Доступные мобы: " . TextFormat::GOLD . implode(", ", $mobs));
                                } elseif ($this->plugin->getLang() == "eng") {
                                    $sender->sendMessage(TextFormat::GREEN . "Available mobs:" . TextFormat::GOLD . implode(", ", $mobs));
                                }
                            }
                        } else {
                            $this->usage($sender);
                        }
                    }

                    if (isset($args[0]) && $args[0] == "del") {
                        $this->plugin->removeMob($sender);
                    }

                    if (isset($args[0]) && $args[0] == "list") {
                        if ($this->plugin->getLang() == "rus") {
                            $sender->sendMessage(TextFormat::GREEN . "Доступные мобы: " . TextFormat::GOLD . implode(", ", $mobs));
                        } elseif ($this->plugin->getLang() == "eng") {
                            $sender->sendMessage(TextFormat::GREEN . "Available mobs:" . TextFormat::GOLD . implode(", ", $mobs));
                        }
                    }

                    if (!isset($args[0])) {
                        $this->usage($sender);
                    }
                    break;
            }
        } else {
            if ($this->plugin->getLang() == "rus") {
                $sender->sendMessage(TextFormat::RED . "Комманда вводиться имени от игрока!");
            } elseif ($this->plugin->getLang() == "eng") {
                $sender->sendMessage(TextFormat::RED . "This command entered the name of the player!");
            }
        }
    }

    public function usage(CommandSender $sender)
    {
        if ($this->plugin->getLang() == "rus") {
            $sender->sendMessage(TextFormat::GOLD . "/morph add <имя моба> - превращение в моба");
            $sender->sendMessage(TextFormat::GOLD . "/morph del - превращение в человека");
            $sender->sendMessage(TextFormat::GOLD . "/morph list - доступные мобы");
        } elseif ($this->plugin->getLang() == "eng") {
            $sender->sendMessage(TextFormat::GOLD . "/morph add <mob name> - transform into a mob");
            $sender->sendMessage(TextFormat::GOLD . "/morph del - turns you back to human");
            $sender->sendMessage(TextFormat::GOLD . "/morph list - available mobs");
        }
    }

}