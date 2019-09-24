<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateIdCommand extends Command
{
    private $flex;

    public function __construct(/* cannot be type-hinted */ $flex)
    {
        $this->flex = $flex;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('symfony:generate-id')
            ->setDescription('Generates a unique ID for this project.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->flex->generateFlexId();
    }
}
