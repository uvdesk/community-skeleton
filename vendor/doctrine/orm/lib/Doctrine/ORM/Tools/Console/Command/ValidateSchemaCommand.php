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

namespace Doctrine\ORM\Tools\Console\Command;

use Doctrine\ORM\Tools\SchemaValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Command to validate that the current mapping is valid.
 *
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 * @link        www.doctrine-project.com
 * @since       1.0
 * @author      Benjamin Eberlei <kontakt@beberlei.de>
 * @author      Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author      Jonathan Wage <jonwage@gmail.com>
 * @author      Roman Borschel <roman@code-factory.org>
 */
class ValidateSchemaCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('orm:validate-schema')
             ->setDescription('Validate the mapping files')
             ->addOption('skip-mapping', null, InputOption::VALUE_NONE, 'Skip the mapping validation check')
             ->addOption('skip-sync', null, InputOption::VALUE_NONE, 'Skip checking if the mapping is in sync with the database')
             ->setHelp('Validate that the mapping files are correct and in sync with the database.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ui = new SymfonyStyle($input, $output);

        $em = $this->getHelper('em')->getEntityManager();
        $validator = new SchemaValidator($em);
        $exit = 0;

        $ui->section('Mapping');

        if ($input->getOption('skip-mapping')) {
            $ui->text('<comment>[SKIPPED] The mapping was not checked.</comment>');
        } elseif ($errors = $validator->validateMapping()) {
            foreach ($errors as $className => $errorMessages) {
                $ui->text(
                    sprintf(
                        '<error>[FAIL]</error> The entity-class <comment>%s</comment> mapping is invalid:',
                        $className
                    )
                );

                $ui->listing($errorMessages);
                $ui->newLine();
            }

            ++$exit;
        } else {
            $ui->success('The mapping files are correct.');
        }

        $ui->section('Database');

        if ($input->getOption('skip-sync')) {
            $ui->text('<comment>[SKIPPED] The database was not checked for synchronicity.</comment>');
        } elseif ( ! $validator->schemaInSyncWithMetadata()) {
            $ui->error('The database schema is not in sync with the current mapping file.');
            $exit += 2;
        } else {
            $ui->success('The database schema is in sync with the mapping files.');
        }

        return $exit;
    }
}
