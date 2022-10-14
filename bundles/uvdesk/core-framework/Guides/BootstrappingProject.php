<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Guides;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BootstrappingProject extends Command
{
    private static $console_guide_resource = __DIR__ . "/../Templates/CLI/Guides";

    protected function configure()
    {
        $this->setName('uvdesk:guides:bootstrapping-project');
        $this->setDescription('Walks you through on how to provide the minimal setup for your support system.');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $consoleOutputText = require self::$console_guide_resource . "/uvdesk-bootstrapping-guide.php";
        
        $output->writeln($consoleOutputText);
    }
}
