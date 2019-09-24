<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Maker;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Doctrine\EntityClassGenerator;
use Symfony\Bundle\MakerBundle\Doctrine\ORMDependencyBuilder;
use Symfony\Bundle\MakerBundle\Exception\RuntimeCommandException;
use Symfony\Bundle\MakerBundle\FileManager;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Security\SecurityConfigUpdater;
use Symfony\Bundle\MakerBundle\Security\UserClassBuilder;
use Symfony\Bundle\MakerBundle\Security\UserClassConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSourceManipulator;
use Symfony\Bundle\MakerBundle\Util\YamlManipulationFailedException;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Security\Core\Encoder\Argon2iPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * @author Ryan Weaver <weaverryan@gmail.com>
 *
 * @internal
 */
final class MakeUser extends AbstractMaker
{
    private $fileManager;

    private $userClassBuilder;

    private $configUpdater;

    public function __construct(FileManager $fileManager, UserClassBuilder $userClassBuilder, SecurityConfigUpdater $configUpdater)
    {
        $this->fileManager = $fileManager;
        $this->userClassBuilder = $userClassBuilder;
        $this->configUpdater = $configUpdater;
    }

    public static function getCommandName(): string
    {
        return 'make:user';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConf)
    {
        $command
            ->setDescription('Creates a new security user class')
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the security user class (e.g. <fg=yellow>User</>)')
            ->addOption('is-entity', null, InputOption::VALUE_NONE, 'Do you want to store user data in the database (via Doctrine)?')
            ->addOption('identity-property-name', null, InputOption::VALUE_REQUIRED, 'Enter a property name that will be the unique "display" name for the user (e.g. <comment>email, username, uuid</comment>)')
            ->addOption('with-password', null, InputOption::VALUE_NONE, 'Will this app be responsible for checking the password? Choose <comment>No</comment> if the password is actually checked by some other system (e.g. a single sign-on server)')
            ->addOption('use-argon2', null, InputOption::VALUE_NONE, 'Use the Argon2i password encoder? (deprecated)')
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeUser.txt'))
        ;

        $inputConf->setArgumentAsNonInteractive('name');
    }

    public function interact(InputInterface $input, ConsoleStyle $io, Command $command)
    {
        if (null === $input->getArgument('name')) {
            $name = $io->ask(
                $command->getDefinition()->getArgument('name')->getDescription(),
                'User'
            );
            $input->setArgument('name', $name);
        }

        $userIsEntity = $io->confirm(
            'Do you want to store user data in the database (via Doctrine)?',
            class_exists(DoctrineBundle::class)
        );
        if ($userIsEntity) {
            $dependencies = new DependencyBuilder();
            ORMDependencyBuilder::buildDependencies($dependencies);

            $missingPackagesMessage = $dependencies->getMissingPackagesMessage(self::getCommandName(), 'Doctrine must be installed to store user data in the database');
            if ($missingPackagesMessage) {
                throw new RuntimeCommandException($missingPackagesMessage);
            }
        }
        $input->setOption('is-entity', $userIsEntity);

        $identityFieldName = $io->ask('Enter a property name that will be the unique "display" name for the user (e.g. <comment>email, username, uuid</comment>)', 'email', [Validator::class, 'validatePropertyName']);
        $input->setOption('identity-property-name', $identityFieldName);

        $io->text('Will this app need to hash/check user passwords? Choose <comment>No</comment> if passwords are not needed or will be checked/hashed by some other system (e.g. a single sign-on server).');
        $userWillHavePassword = $io->confirm('Does this app need to hash/check user passwords?');
        $input->setOption('with-password', $userWillHavePassword);

        if ($userWillHavePassword && !class_exists(NativePasswordEncoder::class) && Argon2iPasswordEncoder::isSupported()) {
            $io->writeln('The newer <comment>Argon2i</comment> password hasher requires PHP 7.2, libsodium or paragonie/sodium_compat. Your system DOES support this algorithm.');
            $io->writeln('You should use <comment>Argon2i</comment> unless your production system will not support it.');
            $useArgon2Encoder = $io->confirm('Use <comment>Argon2i</comment> as your password hasher (bcrypt will be used otherwise)?');
            $input->setOption('use-argon2', $useArgon2Encoder);
        }
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $userClassConfiguration = new UserClassConfiguration(
            $input->getOption('is-entity'),
            $input->getOption('identity-property-name'),
            $input->getOption('with-password')
        );
        if ($input->getOption('use-argon2')) {
            @trigger_error('The "--use-argon2" option is deprecated since MakerBundle 1.12.', E_USER_DEPRECATED);
            $userClassConfiguration->useArgon2(true);
        }

        $userClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            $userClassConfiguration->isEntity() ? 'Entity\\' : 'Security\\'
        );

        // A) Generate the User class
        if ($userClassConfiguration->isEntity()) {
            $entityClassGenerator = new EntityClassGenerator($generator);
            $classPath = $entityClassGenerator->generateEntityClass(
                $userClassNameDetails,
                false, // api resource
                $userClassConfiguration->hasPassword() && interface_exists(PasswordUpgraderInterface::class) // security user
            );
        } else {
            $classPath = $generator->generateClass($userClassNameDetails->getFullName(), 'Class.tpl.php');
        }
        // need to write changes early so we can modify the contents below
        $generator->writeChanges();

        // B) Implement UserInterface
        $manipulator = new ClassSourceManipulator(
            $this->fileManager->getFileContents($classPath),
            true
        );
        $manipulator->setIo($io);
        $this->userClassBuilder->addUserInterfaceImplementation(
            $manipulator,
            $userClassConfiguration
        );
        $generator->dumpFile($classPath, $manipulator->getSourceCode());

        // C) Generate a custom user provider, if necessary
        if (!$userClassConfiguration->isEntity()) {
            $userClassConfiguration->setUserProviderClass($generator->getRootNamespace().'\\Security\\UserProvider');
            $customProviderPath = $generator->generateClass(
                $userClassConfiguration->getUserProviderClass(),
                'security/UserProvider.tpl.php',
                [
                    'user_short_name' => $userClassNameDetails->getShortName(),
                ]
            );
        }

        // D) Update security.yaml
        $securityYamlUpdated = false;
        $path = 'config/packages/security.yaml';
        if ($this->fileManager->fileExists($path)) {
            try {
                $newYaml = $this->configUpdater->updateForUserClass(
                    $this->fileManager->getFileContents($path),
                    $userClassConfiguration,
                    $userClassNameDetails->getFullName()
                );
                $generator->dumpFile($path, $newYaml);
                $securityYamlUpdated = true;
            } catch (YamlManipulationFailedException $e) {
            }
        }

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $io->text('Next Steps:');
        $nextSteps = [
            sprintf('Review your new <info>%s</info> class.', $userClassNameDetails->getFullName()),
        ];
        if ($userClassConfiguration->isEntity()) {
            $nextSteps[] = sprintf(
                'Use <comment>make:entity</comment> to add more fields to your <info>%s</info> entity and then run <comment>make:migration</comment>.',
                $userClassNameDetails->getShortName()
            );
        } else {
            $nextSteps[] = sprintf(
                'Open <info>%s</info> to finish implementing your user provider.',
                $this->fileManager->relativizePath($customProviderPath)
            );
        }

        if (!$securityYamlUpdated) {
            $yamlExample = $this->configUpdater->updateForUserClass(
                'security: {}',
                $userClassConfiguration,
                $userClassNameDetails->getFullName()
            );
            $nextSteps[] = "Your <info>security.yaml</info> could not be updated automatically. You'll need to add the following config manually:\n\n".$yamlExample;
        }

        $nextSteps[] = 'Create a way to authenticate! See https://symfony.com/doc/current/security.html';

        $nextSteps = array_map(function ($step) {
            return sprintf('  - %s', $step);
        }, $nextSteps);
        $io->text($nextSteps);
    }

    public function configureDependencies(DependencyBuilder $dependencies, InputInterface $input = null)
    {
        $dependencies->requirePHP71();

        // checking for SecurityBundle guarantees security.yaml is present
        $dependencies->addClassDependency(
            SecurityBundle::class,
            'security'
        );

        // needed to update the YAML files
        $dependencies->addClassDependency(
            Yaml::class,
            'yaml'
        );

        if (null !== $input && $input->getOption('is-entity')) {
            ORMDependencyBuilder::buildDependencies($dependencies);
        }
    }
}
