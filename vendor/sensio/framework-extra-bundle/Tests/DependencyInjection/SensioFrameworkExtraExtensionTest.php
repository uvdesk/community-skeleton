<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\FrameworkExtraBundle\Tests\DependencyInjection;

use Sensio\Bundle\FrameworkExtraBundle\DependencyInjection\SensioFrameworkExtraExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class SensioFrameworkExtraExtensionTest extends \PHPUnit\Framework\TestCase
{
    public function testDefaultExpressionLanguageConfig()
    {
        $container = new ContainerBuilder();

        $extension = new SensioFrameworkExtraExtension();
        $config = [
            'router' => [
                'annotations' => false,
            ],
        ];

        $extension->load([$config], $container);

        $this->assertAlias($container, 'sensio_framework_extra.security.expression_language.default', 'sensio_framework_extra.security.expression_language');
    }

    public function testOverrideExpressionLanguageConfig()
    {
        $container = new ContainerBuilder();

        $extension = new SensioFrameworkExtraExtension();
        $config = [
            'router' => [
                'annotations' => false,
            ],
            'security' => [
                'expression_language' => 'acme.security.expression_language',
            ],
        ];

        $container->setDefinition('acme.security.expression_language', new Definition());

        $extension->load([$config], $container);

        $this->assertAlias($container, 'acme.security.expression_language', 'sensio_framework_extra.security.expression_language');
    }

    public function testTemplatingControllerPatterns()
    {
        $container = new ContainerBuilder();

        $extension = new SensioFrameworkExtraExtension();
        $config = [
            'router' => [
                'annotations' => false,
            ],
            'templating' => [
                'controller_patterns' => $patterns = ['/foo/', '/bar/', '/foobar/'],
            ],
        ];

        $extension->load([$config], $container);

        $this->assertEquals($patterns, $container->getDefinition('sensio_framework_extra.view.guesser')->getArgument(1));
    }

    private function assertAlias(ContainerBuilder $container, $value, $key)
    {
        $this->assertEquals($value, (string) $container->getAlias($key), sprintf('%s alias is correct', $key));
    }
}
