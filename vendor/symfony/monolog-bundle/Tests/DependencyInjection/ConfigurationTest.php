<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MonologBundle\Tests\DependencyInjection;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\MonologBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigurationTest extends TestCase
{
    /**
     * Some basic tests to make sure the configuration is correctly processed in
     * the standard case.
     */
    public function testProcessSimpleCase()
    {
        $configs = array(
            array(
                'handlers' => array('foobar' => array('type' => 'stream', 'path' => '/foo/bar'))
            )
        );

        $config = $this->process($configs);

        $this->assertArrayHasKey('handlers', $config);
        $this->assertArrayHasKey('foobar', $config['handlers']);
        $this->assertEquals('stream', $config['handlers']['foobar']['type']);
        $this->assertEquals('/foo/bar', $config['handlers']['foobar']['path']);
        $this->assertFalse($config['handlers']['foobar']['nested']);
    }

    public function provideProcessStringChannels()
    {
        return array(
            array('foo', 'foo', true),
            array('!foo', 'foo', false)
        );
    }

    /**
     * @dataProvider provideProcessStringChannels
     */
    public function testProcessStringChannels($string, $expectedString, $isInclusive)
    {
        $configs = array(
            array(
                'handlers' => array(
                    'foobar' => array(
                        'type' => 'stream',
                        'path' => '/foo/bar',
                        'channels' => $string
                    )
                )
            )
        );

        $config = $this->process($configs);

        $this->assertEquals($isInclusive ? 'inclusive' : 'exclusive', $config['handlers']['foobar']['channels']['type']);
        $this->assertCount(1, $config['handlers']['foobar']['channels']['elements']);
        $this->assertEquals($expectedString, $config['handlers']['foobar']['channels']['elements'][0]);
    }

    public function provideGelfPublisher()
    {
        return array(
            array(
                'gelf.publisher'
            ),
            array(
                array(
                    'id' => 'gelf.publisher'
                )
            )
        );
    }

    /**
     * @dataProvider provideGelfPublisher
     */
    public function testGelfPublisherService($publisher)
    {
        $configs = array(
            array(
                'handlers' => array(
                    'gelf' => array(
                        'type' => 'gelf',
                        'publisher' => $publisher,
                    ),
                )
            )
        );

        $config = $this->process($configs);

        $this->assertArrayHasKey('id', $config['handlers']['gelf']['publisher']);
        $this->assertArrayNotHasKey('hostname', $config['handlers']['gelf']['publisher']);
        $this->assertEquals('gelf.publisher', $config['handlers']['gelf']['publisher']['id']);
    }

    public function testArrays()
    {
        $configs = array(
            array(
                'handlers' => array(
                    'foo' => array(
                        'type' => 'stream',
                        'path' => '/foo',
                        'channels' => array('A', 'B')
                    ),
                    'bar' => array(
                        'type' => 'stream',
                        'path' => '/foo',
                        'channels' => array('!C', '!D')
                    ),
                )
            )
        );

        $config = $this->process($configs);

        // Check foo
        $this->assertCount(2, $config['handlers']['foo']['channels']['elements']);
        $this->assertEquals('inclusive', $config['handlers']['foo']['channels']['type']);
        $this->assertEquals('A', $config['handlers']['foo']['channels']['elements'][0]);
        $this->assertEquals('B', $config['handlers']['foo']['channels']['elements'][1]);

        // Check bar
        $this->assertCount(2, $config['handlers']['bar']['channels']['elements']);
        $this->assertEquals('exclusive', $config['handlers']['bar']['channels']['type']);
        $this->assertEquals('C', $config['handlers']['bar']['channels']['elements'][0]);
        $this->assertEquals('D', $config['handlers']['bar']['channels']['elements'][1]);
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testInvalidArrays()
    {
        $configs = array(
            array(
                'handlers' => array(
                    'foo' => array(
                        'type' => 'stream',
                        'path' => '/foo',
                        'channels' => array('A', '!B')
                    )
                )
            )
        );

        $config = $this->process($configs);
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testMergingInvalidChannels()
    {
        $configs = array(
            array(
                'handlers' => array(
                    'foo' => array(
                        'type' => 'stream',
                        'path' => '/foo',
                        'channels' => 'A',
                    )
                )
            ),
            array(
                'handlers' => array(
                    'foo' => array(
                        'channels' => '!B',
                    )
                )
            )
        );

        $config = $this->process($configs);
    }

    public function testWithSwiftMailerHandler()
    {
        $configs = array(
            array(
                'handlers' => array(
                    'swift' => array(
                        'type' => 'swift_mailer',
                        'from_email' => 'foo@bar.com',
                        'to_email' => 'foo@bar.com',
                        'subject' => 'Subject',
                        'mailer'  => 'mailer',
                        'email_prototype' => array(
                            'id' => 'monolog.prototype',
                            'method' => 'getPrototype'
                        )
                    )
                )
            )
        );

        $config = $this->process($configs);

        // Check email_prototype
        $this->assertCount(2, $config['handlers']['swift']['email_prototype']);
        $this->assertEquals('monolog.prototype', $config['handlers']['swift']['email_prototype']['id']);
        $this->assertEquals('getPrototype', $config['handlers']['swift']['email_prototype']['method']);
        $this->assertEquals('mailer', $config['handlers']['swift']['mailer']);
    }

    public function testWithElasticsearchHandler()
    {
        $configs = array(
            array(
                'handlers' => array(
                    'elasticsearch' => array(
                        'type' => 'elasticsearch',
                        'elasticsearch' => array(
                            'id' => 'elastica.client'
                        ),
                        'index' => 'my-index',
                        'document_type' => 'my-record',
                        'ignore_error' => true
                    )
                )
            )
        );

        $config = $this->process($configs);

        $this->assertEquals(true, $config['handlers']['elasticsearch']['ignore_error']);
        $this->assertEquals('my-record', $config['handlers']['elasticsearch']['document_type']);
        $this->assertEquals('my-index', $config['handlers']['elasticsearch']['index']);
    }

    public function testWithConsoleHandler()
    {
        $configs = array(
            array(
                'handlers' => array(
                    'console' => array(
                        'type' => 'console',
                        'verbosity_levels' => array(
                            'VERBOSITY_NORMAL' => 'NOTICE',
                            'verbosity_verbose' => 'info',
                            'VERBOSITY_very_VERBOSE' => 150
                        )
                    )
                )
            )
        );

        $config = $this->process($configs);

        $this->assertSame('console', $config['handlers']['console']['type']);
        $this->assertSame(array(
            OutputInterface::VERBOSITY_NORMAL => Logger::NOTICE,
            OutputInterface::VERBOSITY_VERBOSE => Logger::INFO,
            OutputInterface::VERBOSITY_VERY_VERBOSE => 150,
            OutputInterface::VERBOSITY_QUIET => Logger::ERROR,
            OutputInterface::VERBOSITY_DEBUG => Logger::DEBUG
        ), $config['handlers']['console']['verbosity_levels']);
    }

    public function testWithType()
    {
        $configs = array(
            array(
                'handlers' => array(
                    'foo' => array(
                        'type' => 'stream',
                        'path' => '/foo',
                        'channels' => array(
                            'type' => 'inclusive',
                            'elements' => array('A', 'B')
                        )
                    )
                )
            )
        );

        $config = $this->process($configs);

        // Check foo
        $this->assertCount(2, $config['handlers']['foo']['channels']['elements']);
        $this->assertEquals('inclusive', $config['handlers']['foo']['channels']['type']);
        $this->assertEquals('A', $config['handlers']['foo']['channels']['elements'][0]);
        $this->assertEquals('B', $config['handlers']['foo']['channels']['elements'][1]);
    }

    public function testWithFilePermission()
    {
        $configs = array(
            array(
                'handlers' => array(
                    'foo' => array(
                        'type' => 'stream',
                        'path' => '/foo',
                        'file_permission' => '0666',
                    ),
                    'bar' => array(
                        'type' => 'stream',
                        'path' => '/bar',
                        'file_permission' => 0777
                    )
                )
            )
        );

        $config = $this->process($configs);

        $this->assertSame(0666, $config['handlers']['foo']['file_permission']);
        $this->assertSame(0777, $config['handlers']['bar']['file_permission']);
    }

    public function testWithUseLocking()
    {
        $configs = array(
            array(
                'handlers' => array(
                    'foo' => array(
                        'type' => 'stream',
                        'path' => '/foo',
                        'use_locking' => false,
                    ),
                    'bar' => array(
                        'type' => 'stream',
                        'path' => '/bar',
                        'use_locking' => true,
                    )
                )
            )
        );

        $config = $this->process($configs);

        $this->assertFalse($config['handlers']['foo']['use_locking']);
        $this->assertTrue($config['handlers']['bar']['use_locking']);
    }

    public function testWithNestedHandler()
    {
        $configs = array(
            array(
                'handlers' => array('foobar' => array('type' => 'stream', 'path' => '/foo/bar', 'nested' => true))
            )
        );

        $config = $this->process($configs);


        $this->assertTrue($config['handlers']['foobar']['nested']);
    }
    public function testWithRedisHandler()
    {
        $configs = array(
            array(
                'handlers' => array(
                    'redis' => array(
                        'type' => 'redis',
                        'redis' => array(
                            'host' => '127.0.1.1',
                            'password' => 'pa$$w0rd',
                            'port' => 1234,
                            'database' => 1,
                            'key_name' => 'monolog_redis_test'
                        )
                    )
                )
            )
        );
        $config = $this->process($configs);

        $this->assertEquals('127.0.1.1', $config['handlers']['redis']['redis']['host']);
        $this->assertEquals('pa$$w0rd', $config['handlers']['redis']['redis']['password']);
        $this->assertEquals(1234, $config['handlers']['redis']['redis']['port']);
        $this->assertEquals(1, $config['handlers']['redis']['redis']['database']);
        $this->assertEquals('monolog_redis_test', $config['handlers']['redis']['redis']['key_name']);

        $configs = array(
            array(
                'handlers' => array(
                    'redis' => array(
                        'type' => 'predis',
                        'redis' => array(
                            'host' => '127.0.1.1',
                            'key_name' => 'monolog_redis_test'
                        )
                    )
                )
            )
        );
        $config = $this->process($configs);

        $this->assertEquals('127.0.1.1', $config['handlers']['redis']['redis']['host']);
        $this->assertEquals('monolog_redis_test', $config['handlers']['redis']['redis']['key_name']);
    }

    /**
     * Processes an array of configurations and returns a compiled version.
     *
     * @param array $configs An array of raw configurations
     *
     * @return array A normalized array
     */
    protected function process($configs)
    {
        $processor = new Processor();

        return $processor->processConfiguration(new Configuration(), $configs);
    }
}
