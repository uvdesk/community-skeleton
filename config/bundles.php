<?php

return [
    Webkul\UVDesk\CoreFrameworkBundle\UVDeskCoreFrameworkBundle::class => ['all' => true],
    Webkul\UVDesk\AutomationBundle\UVDeskAutomationBundle::class => ['all' => true],
    Webkul\UVDesk\ExtensionFrameworkBundle\UVDeskExtensionFrameworkBundle::class => ['all' => true],
    Webkul\UVDesk\MailboxBundle\UVDeskMailboxBundle::class => ['all' => true],
    Webkul\UVDesk\SupportCenterBundle\UVDeskSupportCenterBundle::class => ['all' => true],
    Webkul\UVDesk\ApiBundle\UVDeskApiBundle::class => ['all' => true],
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class => ['dev' => true, 'test' => true],
    Knp\Bundle\PaginatorBundle\KnpPaginatorBundle::class => ['all' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
    Symfony\Bundle\DebugBundle\DebugBundle::class => ['dev' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle::class => ['all' => true],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
];
