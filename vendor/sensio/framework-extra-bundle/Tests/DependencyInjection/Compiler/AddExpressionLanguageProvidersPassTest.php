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

use Sensio\Bundle\FrameworkExtraBundle\DependencyInjection\Compiler\AddExpressionLanguageProvidersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class AddExpressionLanguageProvidersPassTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var AddExpressionLanguageProvidersPass
     */
    private $pass;

    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var Definition
     */
    private $expressionLangDefinition;

    public function setUp()
    {
        $this->pass = new AddExpressionLanguageProvidersPass();
        $this->container = new ContainerBuilder();
        $this->expressionLangDefinition = new Definition();
        $this->container->setDefinition('sensio_framework_extra.security.expression_language.default', $this->expressionLangDefinition);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testProcessNoOpNoExpressionLang()
    {
        $this->container->removeDefinition('sensio_framework_extra.security.expression_language.default');
        $this->pass->process($this->container);
    }

    public function testProcessNoOpNoTaggedServices()
    {
        $this->pass->process($this->container);
        $this->assertCount(0, $this->expressionLangDefinition->getMethodCalls());
    }

    public function testProcessAddsTaggedServices()
    {
        $provider = new Definition();
        $provider->setTags([
            'security.expression_language_provider' => [
                [],
            ],
        ]);

        $this->container->setDefinition('provider', $provider);

        $this->pass->process($this->container);

        $methodCalls = $this->expressionLangDefinition->getMethodCalls();
        $this->assertCount(1, $methodCalls);
        $this->assertEquals(['registerProvider', [new Reference('provider')]], $methodCalls[0]);
    }
}
