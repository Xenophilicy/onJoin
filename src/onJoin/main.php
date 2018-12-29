<?php
# MADE BY:
#  __    __                                          __        __  __  __                     
# /  |  /  |                                        /  |      /  |/  |/  |                    
# $$ |  $$ |  ______   _______    ______    ______  $$ |____  $$/ $$ |$$/   _______  __    __ 
# $$  \/$$/  /      \ /       \  /      \  /      \ $$      \ /  |$$ |/  | /       |/  |  /  |
#  $$  $$<  /$$$$$$  |$$$$$$$  |/$$$$$$  |/$$$$$$  |$$$$$$$  |$$ |$$ |$$ |/$$$$$$$/ $$ |  $$ |
#   $$$$  \ $$    $$ |$$ |  $$ |$$ |  $$ |$$ |  $$ |$$ |  $$ |$$ |$$ |$$ |$$ |      $$ |  $$ |
#  $$ /$$  |$$$$$$$$/ $$ |  $$ |$$ \__$$ |$$ |__$$ |$$ |  $$ |$$ |$$ |$$ |$$ \_____ $$ \__$$ |
# $$ |  $$ |$$       |$$ |  $$ |$$    $$/ $$    $$/ $$ |  $$ |$$ |$$ |$$ |$$       |$$    $$ |
# $$/   $$/  $$$$$$$/ $$/   $$/  $$$$$$/  $$$$$$$/  $$/   $$/ $$/ $$/ $$/  $$$$$$$/  $$$$$$$ |
#                                         $$ |                                      /  \__$$ |
#                                         $$ |                                      $$    $$/ 
#                                         $$/                                        $$$$$$/           

namespace onJoin;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\config;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\command\ConsoleCommandSender;

use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;

class Main extends PluginBase implements Listener{

    private $config;

    public function onLoad(){
        $this->saveDefaultConfig();
        $this->config = new Config($this->getDataFolder()."config.yml", Config::YAML);
        $this->config->getAll();
        $this->getLogger()->info("§eonJoin by §6Xenophilicy §eis loading...");
    }

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§6onJoin§a has been enabled!");
        $forminstalled = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if($forminstalled == null){
            $this->getLogger()->critical("Required dependancy 'FormAPI' not installed! Disabling plugin...");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }
    }

    public function onDisable(){
        $this->getLogger()->info("§6onJoin§c has been disabled!");
    }

    public function onJoin(PlayerJoinEvent $event){
            $player = $event->getPlayer();
            $this->joinUI($player);
    }

    public function joinUI($player){
        $formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = new SimpleForm(function (Player $player, $data){
            if($data === null){
                return;
            }
            $consolecmd = new ConsoleCommandSender();
            switch($data){
                case 0:
                    $command = $this->config->getNested("Button-1.Command");
                    $runAs = $this->config->getNested("Button-1.Run-As");
                    if ($runAs == "Server"){
                        $this->getServer()->dispatchCommand($consolecmd, $command);
                    }
                    if ($runAs == "Player"){
                        $this->getServer()->dispatchCommand($player, $command);
                    }
                    break;
                case 1:
                    $command = $this->config->getNested("Button-2.Command");
                    $runAs = $this->config->getNested("Button-2.Run-As");
                    if ($runAs == "Server"){
                        $this->getServer()->dispatchCommand($consolecmd, $command);
                    }
                    if ($runAs == "Player"){
                        $this->getServer()->dispatchCommand($player, $command);
                    }
                    break;
                case 2:
                    $command = $this->config->getNested("Button-3.Command");
                    $runAs = $this->config->getNested("Button-3.Run-As");
                    if ($runAs == "Server"){
                        $this->getServer()->dispatchCommand($consolecmd, $command);
                    }
                    if ($runAs == "Player"){
                        $this->getServer()->dispatchCommand($player, $command);
                    }
                    break;
            }
            return true;
        });
        $form->setTitle($this->config->get("UI-Title"));
        $form->setContent($this->config->get("Content-Message"));
        $b1Title = $this->config->getNested("Button-1.Title");
        $b2Title = $this->config->getNested("Button-2.Title");
        $b3Title = $this->config->getNested("Button-3.Title");
        if (!$b1Title == false){
            $form->addButton($b1Title);
        }
        if (!$b2Title == false){
            $form->addButton($b2Title);
        }
        if (!$b3Title == false){
            $form->addButton($b3Title);
        }
        $form->sendToPlayer($player);
    }
}
?>