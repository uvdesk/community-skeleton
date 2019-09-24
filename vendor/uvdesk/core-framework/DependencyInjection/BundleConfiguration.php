<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class BundleConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('uvdesk')
            ->children()
                ->node('site_url', 'scalar')->defaultValue('127.0.0.1')->end()
                ->node('upload_manager', 'array')
                    ->children()
                        ->node('id', 'scalar')->defaultValue('uvdesk.core.fs.upload.manager')->end()
                    ->end()
                ->end()
                ->node('support_email', 'array')
                    ->children()
                        ->node('id', 'scalar')->defaultValue('support@localhost')->end()
                        ->node('name', 'scalar')->defaultValue('UVDesk Community')->end()
                        ->node('mailer_id', 'scalar')->defaultValue('default')->end()
                    ->end()
                ->end()
                ->node('default', 'array')
                    ->children()
                        ->node('ticket', 'array')
                            ->children()
                                ->node('type', 'scalar')->defaultValue('support')->end()
                                ->node('status', 'scalar')->defaultValue('open')->end()
                                ->node('priority', 'scalar')->defaultValue('low')->end()
                            ->end()
                        ->end()
                        ->node('templates', 'array')
                            ->children()
                                ->node('email', 'scalar')->defaultValue('mail.html.twig')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
