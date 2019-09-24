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

use Doctrine\ORM\Tools\ConvertDoctrine1Schema;
use Doctrine\ORM\Tools\EntityGenerator;
use Doctrine\ORM\Tools\Export\ClassMetadataExporter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to convert a Doctrine 1 schema to a Doctrine 2 mapping file.
 *
 * @link    www.doctrine-project.org
 * @since   2.0
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 */
class ConvertDoctrine1SchemaCommand extends Command
{
    /**
     * @var EntityGenerator|null
     */
    private $entityGenerator = null;

    /**
     * @var ClassMetadataExporter|null
     */
    private $metadataExporter = null;

    /**
     * @return EntityGenerator
     */
    public function getEntityGenerator()
    {
        if ($this->entityGenerator == null) {
            $this->entityGenerator = new EntityGenerator();
        }

        return $this->entityGenerator;
    }

    /**
     * @param EntityGenerator $entityGenerator
     *
     * @return void
     */
    public function setEntityGenerator(EntityGenerator $entityGenerator)
    {
        $this->entityGenerator = $entityGenerator;
    }

    /**
     * @return ClassMetadataExporter
     */
    public function getMetadataExporter()
    {
        if ($this->metadataExporter == null) {
            $this->metadataExporter = new ClassMetadataExporter();
        }

        return $this->metadataExporter;
    }

    /**
     * @param ClassMetadataExporter $metadataExporter
     *
     * @return void
     */
    public function setMetadataExporter(ClassMetadataExporter $metadataExporter)
    {
        $this->metadataExporter = $metadataExporter;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('orm:convert-d1-schema')
             ->setAliases(['orm:convert:d1-schema'])
             ->setDescription('Converts Doctrine 1.x schema into a Doctrine 2.x schema')
             ->addArgument('from-path', InputArgument::REQUIRED, 'The path of Doctrine 1.X schema information.')
             ->addArgument('to-type', InputArgument::REQUIRED, 'The destination Doctrine 2.X mapping type.')
             ->addArgument('dest-path', InputArgument::REQUIRED, 'The path to generate your Doctrine 2.X mapping information.')
             ->addOption('from', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Optional paths of Doctrine 1.X schema information.', [])
             ->addOption('extend', null, InputOption::VALUE_OPTIONAL, 'Defines a base class to be extended by generated entity classes.')
             ->addOption('num-spaces', null, InputOption::VALUE_OPTIONAL, 'Defines the number of indentation spaces', 4)
             ->setHelp('Converts Doctrine 1.x schema into a Doctrine 2.x schema.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Process source directories
        $fromPaths = array_merge([$input->getArgument('from-path')], $input->getOption('from'));

        // Process destination directory
        $destPath = realpath($input->getArgument('dest-path'));

        $toType = $input->getArgument('to-type');
        $extend = $input->getOption('extend');
        $numSpaces = $input->getOption('num-spaces');

        $this->convertDoctrine1Schema($fromPaths, $destPath, $toType, $numSpaces, $extend, $output);
    }

    /**
     * @param array           $fromPaths
     * @param string          $destPath
     * @param string          $toType
     * @param int             $numSpaces
     * @param string|null     $extend
     * @param OutputInterface $output
     *
     * @throws \InvalidArgumentException
     */
    public function convertDoctrine1Schema(array $fromPaths, $destPath, $toType, $numSpaces, $extend, OutputInterface $output)
    {
        foreach ($fromPaths as &$dirName) {
            $dirName = realpath($dirName);

            if ( ! file_exists($dirName)) {
                throw new \InvalidArgumentException(
                    sprintf("Doctrine 1.X schema directory '<info>%s</info>' does not exist.", $dirName)
                );
            }

            if ( ! is_readable($dirName)) {
                throw new \InvalidArgumentException(
                    sprintf("Doctrine 1.X schema directory '<info>%s</info>' does not have read permissions.", $dirName)
                );
            }
        }

        if ( ! file_exists($destPath)) {
            throw new \InvalidArgumentException(
                sprintf("Doctrine 2.X mapping destination directory '<info>%s</info>' does not exist.", $destPath)
            );
        }

        if ( ! is_writable($destPath)) {
            throw new \InvalidArgumentException(
                sprintf("Doctrine 2.X mapping destination directory '<info>%s</info>' does not have write permissions.", $destPath)
            );
        }

        $cme = $this->getMetadataExporter();
        $exporter = $cme->getExporter($toType, $destPath);

        if (strtolower($toType) === 'annotation') {
            $entityGenerator = $this->getEntityGenerator();
            $exporter->setEntityGenerator($entityGenerator);

            $entityGenerator->setNumSpaces($numSpaces);

            if ($extend !== null) {
                $entityGenerator->setClassToExtend($extend);
            }
        }

        $converter = new ConvertDoctrine1Schema($fromPaths);
        $metadata = $converter->getMetadata();

        if ($metadata) {
            $output->writeln('');

            foreach ($metadata as $class) {
                $output->writeln(sprintf('Processing entity "<info>%s</info>"', $class->name));
            }

            $exporter->setMetadata($metadata);
            $exporter->export();

            $output->writeln(PHP_EOL . sprintf(
                'Converting Doctrine 1.X schema to "<info>%s</info>" mapping type in "<info>%s</info>"', $toType, $destPath
            ));
        } else {
            $output->writeln('No Metadata Classes to process.');
        }
    }
}
