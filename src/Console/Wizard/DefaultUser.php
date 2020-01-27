<?php

namespace App\Console\Wizard;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DefaultUser extends Command
{
    private $user;
    private $role;
    private $container;
    private $entityManager;
    private $questionHelper;

    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('uvdesk_wizard:defaults:create-user')
            ->setDescription('Creates a new user instance')
            ->setHidden(true);
        
        // Arguments
        $this
            ->addArgument('role', InputArgument::REQUIRED, "Access level of the user restricting access to parts of helpdesk system")
            ->addArgument('name', InputArgument::OPTIONAL, "Name of the user")
            ->addArgument('email', InputArgument::OPTIONAL, "Email address of the user")
            ->addArgument('password', InputArgument::OPTIONAL, "Password of the user account");
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->user = new CoreEntities\User();
        $this->questionHelper = $this->getHelper('question');
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        // Check if the provided role is valid. Skip otherwise.
        $this->role = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportRole')->findOneByCode($input->getArgument('role'));
        
        if (empty($this->role)) {
            return;
        }

        $output->writeln("\n      Please enter the following user details:\n");

        // Prompt Email
        $email = $this->promptUserEmailInteractively($input, $output);
        
        // Retrieve existing user or generate new empty user
        $this->user = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneByEmail($email) ?: $this->user->setEmail($email);

        // Prompt user name
        $username = trim($this->user->getFirstName() . ' ' . $this->user->getLastName());
        $username = $this->promptUserNameInteractively($input, $output, $username);
        $username = explode(' ', $username, 2);

        $this->user->setFirstName($username[0]);
        $this->user->setLastName(!empty($username[1]) ? $username[1] : '');
        
        // Prompt user password if not set
        if ($this->user->getPassword() == null) {
            $password = null;
            $confirmPassword = null;
            $warningFlag = false;

            do {
                if ($password != $confirmPassword) {
                    $warningFlag = true;
                    $output->writeln("      <comment>Warning</comment>: Passwords do not match");
                }

                $password = $this->promptUserPasswordInteractively($input, $output);
                
                if ($warningFlag) {
                    $output->write("\033[1A");
                    $output->write("\033[K");
                }

                $confirmPassword = $this->promptUserPasswordInteractively($input, $output, true);
            } while ($password != $confirmPassword);

            $encodedPassword = $this->container->get('security.password_encoder')->encodePassword($this->user, $password);
            $this->user->setPassword($encodedPassword);
        }

        for ($i = 0; $i < 5; $i++) {
            $output->write("\033[1A");
            $output->write("\033[K");
        }

        return;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('no-interaction')) {
            $name = $input->getArgument('name');
            $email = $input->getArgument('email');
            $password = $input->getArgument('password');
            
            // Check if the provided role is valid. Skip otherwise.
            $this->role = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportRole')->findOneByCode($input->getArgument('role'));
            
            if (empty($name) || empty($email) | empty($password)) {
                $output->writeln("\n      <fg=red;>[Error]</> Insufficient arguments provided.");

                return 2;
            } else if (empty($this->role)) {
                $output->writeln("\n      <fg=red;>[Error]</> No valid support role provided.");

                return 2;
            } else {
                $this->user = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneByEmail($email) ?: $this->user->setEmail($email);

                $username = explode(' ', $name, 2);
                $encodedPassword = $this->container->get('security.password_encoder')->encodePassword($this->user, $password);

                $this->user
                    ->setFirstName($username[0])
                    ->setLastName(!empty($username[1]) ? $username[1] : null)
                    ->setPassword($encodedPassword);
            }
        } else if (empty($this->role)) {
            $output->writeln("\n      <fg=red;>[Error]</> No support role found for code <comment>" . $input->getArgument('role') . "</comment>.");

            return 2;
        }
        
        $accountExistsFlag = false;

        if ($this->user->getId() != null) {
            // If user id is set, that means the entity has been persisted to database before. Check for any existing accounts
            $targetRole = $this->role->getId();
            $userInstanceCollection = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:UserInstance')->findByUser($this->user);

            foreach ($userInstanceCollection as $userInstance) {
                $userRole = $userInstance->getSupportRole()->getId();

                // Check if user account exists with the opted user permission level
                if (in_array($targetRole, [1, 2, 3]) && in_array($userRole, [1, 2, 3])) {
                    // User is being set for an member level role
                    $accountExistsFlag = true;
                    break;
                } else if ($targetRole == 4 && $userRole == $targetRole) {
                    // User is being set for a customer level role
                    $accountExistsFlag = true;
                    break;
                }
            }
        } else {
            $this->user->setIsEnabled(true);
        }

        if (false === $accountExistsFlag) {
            $this->entityManager->persist($this->user);
            $this->entityManager->flush();

            $userInstance = new CoreEntities\UserInstance();
            $userInstance->setSource('website');
            $userInstance->setIsActive(true);
            $userInstance->setIsVerified(true);
            $userInstance->setUser($this->user);
            $userInstance->setSupportRole($this->role);

            $this->entityManager->persist($userInstance);
            $this->entityManager->flush();
        } else {
            return 1;
        }
    }

    private function promptUserEmailInteractively(InputInterface $input, OutputInterface $output)
    {
        $email = null;
        $warningFlag = false;

        do {
            $email = $this->questionHelper->ask($input, $output, new Question("      <info>Email</info>: ", $email));
            $output->write("\033[1A");
            $output->write("\033[K");

            if ($warningFlag) {
                $output->write("\033[1A");
                $output->write("\033[K");
            }

            if (empty($email)) {
                $output->writeln("      <comment>Warning</comment>: Email address cannot be left blank");
                $warningFlag = true;
            } else {
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);

                if (false == filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $output->writeln("      <comment>Warning</comment>: <comment>$email</comment> is not a valid email address");
                    $email = null;
                    $warningFlag = true;
                }
            }
        } while (empty($email));

        return $email;
    }

    private function promptUserNameInteractively(InputInterface $input, OutputInterface $output, $username = '')
    {
        $warningFlag = false;

        do {
            if (empty($username)) {
                $question = new Question("      <info>Name</info>: ", $username);
            } else {
                $question = new Question("      <info>Name</info> <comment>[$username]</comment>: ", $username);
                $question->setAutocompleterValues((array) $username);
            }

            $username = $this->questionHelper->ask($input, $output, $question);
            $output->write("\033[1A");
            $output->write("\033[K");

            if ($warningFlag) {
                $output->write("\033[1A");
                $output->write("\033[K");
            }

            if (empty($username)) {
                $warningFlag = true;
                $output->writeln("      <comment>Warning<comment>: Name of the user cannot be left blank");
            }
        } while (empty($username));

        return $username;
    }

    private function promptUserPasswordInteractively(InputInterface $input, OutputInterface $output, $confirmDialog = false)
    {
        $password = null;
        $warningFlag = false;

        do {
            $prompt = new Question(sprintf("      <info>%sPassword</info>: ", $confirmDialog ? 'Confirm ' : ''));
            $prompt->setHidden(true);
            $prompt->setHiddenFallback(false);

            $password = $this->questionHelper->ask($input, $output, $prompt);
            $output->write("\033[1A");
            $output->write("\033[K");
            
            if ($warningFlag) {
                $output->write("\033[1A");
                $output->write("\033[K");
            }

            if (false == $confirmDialog && empty($password)) {
                $warningFlag = true;
                $output->writeln(sprintf("      <comment>Warning</comment>: %sPassword cannot be left blank", $confirmDialog ? 'Confirm ' : ''));
            } else if (false == $confirmDialog && (strlen($password) < 8 || strlen($password) > 32)) {
                $warningFlag = true;
                // Sanatize password and compare if they match
                $output->writeln("      <comment>Warning</comment>: Password needs to be 8-32 characters long");
                $password = null;
            }
        } while (false == $confirmDialog && empty($password));

        return $password;
    }
}
