<?php

namespace Webkul\UVDesk\MailboxBundle\Console;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RefreshMailboxCommand extends Command
{
    private $container;
    private $entityManager;

    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('uvdesk:refresh-mailbox');
        $this->setDescription('Check if any new emails have been received and process them into tickets');

        $this->addArgument('emails', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, "Email address of the mailboxes you wish to update");
        $this->addOption('timestamp', 't', InputOption::VALUE_REQUIRED, "Fetch messages no older than the given timestamp");
    }

    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        // Sanitize emails
        $mailboxEmailCollection = array_map(function ($email) {
            return filter_var($email, FILTER_SANITIZE_EMAIL);
        }, $input->getArgument('emails'));
       
        // Stop execution if no valid emails have been specified
        if (empty($mailboxEmailCollection)) {
            if (false === $input->getOption('no-interaction')) {
                $output->writeln("\n <comment>No valid mailbox emails specified.</comment>\n");
            }

            return Command::INVALID;
        }

        // Process mailboxes
        $timestamp = new \DateTime(sprintf("-%u minutes", (int) ($input->getOption('timestamp') ?: 1440)));
        $output->writeln("\n <comment>1. Processing uvdesk mailbox configuration.</comment>");

        foreach ($mailboxEmailCollection as $mailboxEmail) {
            try {
                $mailbox = $this->container->get('uvdesk.mailbox')->getMailboxByEmail($mailboxEmail);

                if (false == $mailbox['enabled']) {
                    if (false === $input->getOption('no-interaction')) {
                        $output->writeln("\n <comment>Mailbox for email </comment><info>$mailboxEmail</info><comment> is not enabled.</comment>\n");
                    }
    
                    continue;
                } else if (empty($mailbox['imap_server'])) {
                    if (false === $input->getOption('no-interaction')) {
                        $output->writeln("\n <comment>No imap configurations defined for email </comment><info>$mailboxEmail</info><comment>.</comment>\n");
                    }
    
                    continue;
                }
            } catch (\Exception $e) {
                if (false == $input->getOption('no-interaction')) {
                    $output->writeln("\n <comment>Mailbox for email </comment><info>$mailboxEmail</info><comment> not found.</comment>\n");

                    return Command::INVALID;
                }

                continue;
            }

            $output->writeln("\n <comment>2. Opening imap stream... </comment>");
            $this->refreshMailbox($mailbox['imap_server']['host'], $mailbox['imap_server']['username'], base64_decode($mailbox['imap_server']['password']), $timestamp, $output, $mailbox);

        }

        return Command::SUCCESS;
    }

    public function refreshMailbox($server_host, $server_username, $server_password, \DateTime $timestamp, OutputInterface $output, $mailbox)
    {
        $imap = imap_open($server_host, $server_username, $server_password);
        $output->writeln("\n <comment>3. IMAP stream opened.</comment>");

        if ($imap) {
            $timeSpan = $timestamp->format('d F Y');
            $output->writeln("\n <comment>4. Fetching Email collection since </comment><info>$timeSpan</info><comment>.</comment>");
            $emailCollection = imap_search($imap, 'SINCE "' . $timestamp->format('d F Y') . '"');

            if (is_array($emailCollection)) {
                $emailCount = count($emailCollection);
                $useSecureConnection = $this->isSecureConnectionAvailable();

                $output->writeln("\n <comment>5. Total fetched email -> </comment><info>$emailCount</info><comment></comment>");
                $output->writeln("\n <comment>6. Starting to convert Emails into Tickets -> </comment>\n=============================================\n=============================================\n");
                $counter = 1;
                
                foreach ($emailCollection as $id => $messageNumber) {
                    $output->writeln("\n <comment> Converting email </comment><info>$counter</info><comment> out of </comment><info>$emailCount</info><comment>.</comment>");
                    $message = imap_fetchbody($imap, $messageNumber, "");
                    $this->pushMessage($message, $useSecureConnection, $output);
                    if (true == $mailbox['deleted']) {
                        imap_delete($imap, $messageNumber);
                    }
                    $counter ++;
                }

                $output->writeln("\n <comment>Mailbox refreshed successfully !!!</comment>");
                if (true == $mailbox['deleted']) {
                    imap_expunge($imap);
                    imap_close($imap,CL_EXPUNGE);
                }
            }
        }

        return;
    }

    public function pushMessage($message, bool $secure = false, $output)
    {
        $router = $this->container->get('router');
        $router->getContext()->setHost($this->container->getParameter('uvdesk.site_url'));
        $router->getContext()->setScheme(true === $secure ? 'https' : 'http');

        $curlHandler = curl_init();
        $requestUrl = $router->generate('helpdesk_member_mailbox_notification', [], UrlGeneratorInterface::ABSOLUTE_URL);   
        
        curl_setopt($curlHandler, CURLOPT_HEADER, 0);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandler, CURLOPT_POST, 1);
        curl_setopt($curlHandler, CURLOPT_URL, $requestUrl);
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, http_build_query(['email' => $message]));

        $curlResponse = curl_exec($curlHandler);
        if ($curlResponse != 200 ) {
            $curlResponse = $this->getTagValue($curlResponse, 'title');
            $output->writeln("\n <comment> Error -> </comment><info>$curlResponse</info><comment></comment>");
            exit();
        }
        curl_close($curlHandler);
    }

    function getTagValue($string, $tag)
    {
        $pattern = "/<{$tag}>(.*?)<\/{$tag}>/s";
        preg_match($pattern, $string, $matches);
        return isset($matches[1]) ? $matches[1] : '';
    }

    protected function isSecureConnectionAvailable()
    {
        $headers = [CURLOPT_NOBODY => true, CURLOPT_HEADER => false];
        $curlHandler = curl_init('https://' . $this->container->getParameter('uvdesk.site_url'));

        curl_setopt_array($curlHandler, $headers);
        curl_exec($curlHandler);

        $isSecureRequestAvailable = curl_errno($curlHandler) === 0 ? true : false;
        curl_close($curlHandler);

        return $isSecureRequestAvailable;
    }
}
