<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM\Tools\Console\Command\ClearCache;

use Doctrine\ORM\Cache;
use Doctrine\ORM\Cache\Region\DefaultRegion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Command to clear a entity cache region.
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class EntityRegionCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('orm:clear-cache:region:entity')
             ->setDescription('Clear a second-level cache entity region')
             ->addArgument('entity-class', InputArgument::OPTIONAL, 'The entity name.')
             ->addArgument('entity-id', InputArgument::OPTIONAL, 'The entity identifier.')
             ->addOption('all', null, InputOption::VALUE_NONE, 'If defined, all entity regions will be deleted/invalidated.')
             ->addOption('flush', null, InputOption::VALUE_NONE, 'If defined, all cache entries will be flushed.')
             ->setHelp(<<<EOT
The <info>%command.name%</info> command is meant to clear a second-level cache entity region for an associated Entity Manager.
It is possible to delete/invalidate all entity region, a specific entity region or flushes the cache provider.

The execution type differ on how you execute the command.
If you want to invalidate all entries for an entity region this command would do the work:

<info>%command.name% 'Entities\MyEntity'</info>

To invalidate a specific entry you should use :

<info>%command.name% 'Entities\MyEntity' 1</info>

If you want to invalidate all entries for the all entity regions:

<info>%command.name% --all</info>

Alternatively, if you want to flush the configured cache provider for an entity region use this command:

<info>%command.name% 'Entities\MyEntity' --flush</info>

Finally, be aware that if <info>--flush</info> option is passed,
not all cache providers are able to flush entries, because of a limitation of its execution nature.
EOT
             );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ui = new SymfonyStyle($input, $output);

        $em          = $this->getHelper('em')->getEntityManager();
        $entityClass = $input->getArgument('entity-class');
        $entityId    = $input->getArgument('entity-id');
        $cache       = $em->getCache();

        if ( ! $cache instanceof Cache) {
            throw new \InvalidArgumentException('No second-level cache is configured on the given EntityManager.');
        }

        if ( ! $entityClass && ! $input->getOption('all')) {
            throw new \InvalidArgumentException('Invalid argument "--entity-class"');
        }

        if ($input->getOption('flush')) {
            $entityRegion  = $cache->getEntityCacheRegion($entityClass);

            if ( ! $entityRegion instanceof DefaultRegion) {
                throw new \InvalidArgumentException(sprintf(
                    'The option "--flush" expects a "Doctrine\ORM\Cache\Region\DefaultRegion", but got "%s".',
                    is_object($entityRegion) ? get_class($entityRegion) : gettype($entityRegion)
                ));
            }

            $entityRegion->getCache()->flushAll();

            $ui->comment(sprintf('Flushing cache provider configured for entity named <info>"%s"</info>', $entityClass));

            return;
        }

        if ($input->getOption('all')) {
            $ui->comment('Clearing <info>all</info> second-level cache entity regions');

            $cache->evictEntityRegions();

            return;
        }

        if ($entityId) {
            $ui->comment(
                sprintf(
                    'Clearing second-level cache entry for entity <info>"%s"</info> identified by <info>"%s"</info>',
                    $entityClass,
                    $entityId
                )
            );
            $cache->evictEntity($entityClass, $entityId);

            return;
        }

        $ui->comment(sprintf('Clearing second-level cache for entity <info>"%s"</info>', $entityClass));
        $cache->evictEntityRegion($entityClass);
    }
}
