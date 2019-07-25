<?php

namespace App\Console;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EnvironmentVariables extends Command
{
    private $path;
    private $conf;
    private $envvars;
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('uvdesk_wizard:env:update')
            ->setDescription('Makes changes to .env located in project root to update environment variables.')
            ->setHidden(true);

        $this
            ->addArgument('name', InputArgument::REQUIRED, "Name of the environment variable")
            ->addArgument('value', InputArgument::REQUIRED, "Value to set for the evironment variable");
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->path = $this->container->get('kernel')->getProjectDir() . '/.env';
        
        $this->conf = file_get_contents($this->path);
        $this->envvars = (new Dotenv())->parse($this->conf);
        $this->envvars[strtoupper($input->getArgument('name'))] = $input->getArgument('value');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ('dev' != $this->container->get('kernel')->getEnvironment()) {
            throw new \Exception("\nThis command is only allowed to be used in development environment.", 500);
        }

        $read_line = function ($line) {
            if (trim($line) && trim($line)[0] != '#' && strpos(trim($line), '=') > 0) {
                try {
                    list($var, $value) = explode("=", trim($line));
    
                    if (isset($this->envvars[strtoupper($var)])) {
                        return strtoupper($var) . "=" . $this->envvars[strtoupper($var)];
                    }
                } catch (\Exception $e) {
                    // Do nothing
                }
            }

            return $line;
        };

        $stream = array_map($read_line, file($this->path, FILE_IGNORE_NEW_LINES));
        $stream = implode("\n", $stream) . "\n";

        if (trim($stream) != trim($this->conf)) {
            file_put_contents($this->path, $stream);
        }
    }
}