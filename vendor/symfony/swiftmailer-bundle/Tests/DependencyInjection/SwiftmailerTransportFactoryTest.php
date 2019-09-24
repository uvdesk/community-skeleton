<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\SwiftmailerBundle\Tests\DependencyInjection;

use Symfony\Bundle\SwiftmailerBundle\DependencyInjection\SwiftmailerTransportFactory;
use Symfony\Component\Routing\RequestContext;

class SwiftmailerTransportFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateTransportWithSmtp()
    {
        $options = [
            'transport' => 'smtp',
            'username' => 'user',
            'password' => 'pass',
            'host' => 'host',
            'port' => 1234,
            'timeout' => 42,
            'source_ip' => 'source_ip',
            'local_domain' => 'local_domain',
            'encryption' => 'tls',
            'auth_mode' => 'plain',
        ];

        $transport = SwiftmailerTransportFactory::createTransport(
            $options,
            new RequestContext(),
            new \Swift_Events_SimpleEventDispatcher()
        );
        $this->assertInstanceOf('Swift_Transport_EsmtpTransport', $transport);
        $this->assertSame($transport->getHost(), $options['host']);
        $this->assertSame($transport->getPort(), $options['port']);
        $this->assertSame($transport->getEncryption(), $options['encryption']);
        $this->assertSame($transport->getTimeout(), $options['timeout']);
        $this->assertSame($transport->getSourceIp(), $options['source_ip']);
        $this->assertSame($transport->getLocalDomain(), $options['local_domain']);

        $authHandler = current($transport->getExtensionHandlers());
        $this->assertSame($authHandler->getUsername(), $options['username']);
        $this->assertSame($authHandler->getPassword(), $options['password']);
        $this->assertSame($authHandler->getAuthMode(), $options['auth_mode']);
    }

    public function testCreateTransportWithSendmail()
    {
        $options = [
            'transport' => 'sendmail',
            'command' => '/usr/sbin/sendmail -bs',
        ];

        $transport = SwiftmailerTransportFactory::createTransport(
            $options,
            new RequestContext(),
            new \Swift_Events_SimpleEventDispatcher()
        );
        $this->assertInstanceOf('Swift_Transport_SendmailTransport', $transport);
    }

    public function testCreateTransportWithNull()
    {
        $options = [
            'transport' => 'null',
        ];

        $transport = SwiftmailerTransportFactory::createTransport(
            $options,
            new RequestContext(),
            new \Swift_Events_SimpleEventDispatcher()
        );
        $this->assertInstanceOf('Swift_Transport_NullTransport', $transport);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The fake_encryption encryption is not supported
     */
    public function testCreateTransportWithWrongEncryption()
    {
        SwiftmailerTransportFactory::createTransport(
            [
                'transport' => 'smtp',
                'username' => 'user',
                'password' => 'pass',
                'host' => 'host',
                'port' => 1234,
                'timeout' => 42,
                'source_ip' => 'source_ip',
                'local_domain' => 'local_domain',
                'encryption' => 'fake_encryption',
                'auth_mode' => 'auth_mode',
            ],
            new RequestContext(),
            new \Swift_Events_SimpleEventDispatcher()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The fake_auth authentication mode is not supported
     */
    public function testCreateTransportWithWrongAuthMode()
    {
        SwiftmailerTransportFactory::createTransport(
            [
                'transport' => 'smtp',
                'username' => 'user',
                'password' => 'pass',
                'host' => 'host',
                'port' => 1234,
                'timeout' => 42,
                'source_ip' => 'source_ip',
                'local_domain' => 'local_domain',
                'encryption' => 'tls',
                'auth_mode' => 'fake_auth',
            ],
            new RequestContext(),
            new \Swift_Events_SimpleEventDispatcher()
        );
    }

    public function testCreateTransportWithSmtpAndWithoutRequestContext()
    {
        $options = [
            'transport' => 'smtp',
            'username' => 'user',
            'password' => 'pass',
            'host' => 'host',
            'port' => 1234,
            'timeout' => 42,
            'source_ip' => 'source_ip',
            'local_domain' => 'local_domain',
            'encryption' => 'tls',
            'auth_mode' => 'plain',
        ];

        $transport = SwiftmailerTransportFactory::createTransport(
            $options,
            null,
            new \Swift_Events_SimpleEventDispatcher()
        );
        $this->assertInstanceOf('Swift_Transport_EsmtpTransport', $transport);
        $this->assertSame($transport->getHost(), $options['host']);
        $this->assertSame($transport->getPort(), $options['port']);
        $this->assertSame($transport->getEncryption(), $options['encryption']);
        $this->assertSame($transport->getTimeout(), $options['timeout']);
        $this->assertSame($transport->getSourceIp(), $options['source_ip']);
        $this->assertSame($transport->getLocalDomain(), $options['local_domain']);

        $authHandler = current($transport->getExtensionHandlers());
        $this->assertSame($authHandler->getUsername(), $options['username']);
        $this->assertSame($authHandler->getPassword(), $options['password']);
        $this->assertSame($authHandler->getAuthMode(), $options['auth_mode']);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The Swiftmailer URL "smtp://localhost:25&auth_mode=cra-md5" is not valid.
     */
    public function testCreateTransportWithBadURLFormat()
    {
        $options = [
            'url' => 'smtp://localhost:25&auth_mode=cra-md5',
            'transport' => 'smtp',
            'username' => null,
            'password' => null,
            'host' => 'localhost',
            'port' => null,
            'timeout' => 30,
            'source_ip' => null,
            'local_domain' => null,
            'encryption' => null,
            'auth_mode' => null,
        ];

        SwiftmailerTransportFactory::createTransport($options, null, new \Swift_Events_SimpleEventDispatcher());
    }

    /**
     * @dataProvider optionsAndResultExpected
     */
    public function testResolveOptions($options, $expected)
    {
        $result = SwiftmailerTransportFactory::resolveOptions($options);
        $this->assertEquals($expected, $result);
    }

    public function optionsAndResultExpected()
    {
        return [
            [
                [
                    'url' => '',
                ],
                [
                    'transport' => 'null',
                    'username' => null,
                    'password' => null,
                    'command' => null,
                    'host' => null,
                    'port' => 25,
                    'timeout' => null,
                    'source_ip' => null,
                    'local_domain' => null,
                    'encryption' => null,
                    'auth_mode' => null,
                    'url' => '',
                ],
            ],
            [
                [
                    'url' => 'smtp://user:pass@host:1234',
                ],
                [
                    'transport' => 'smtp',
                    'username' => 'user',
                    'password' => 'pass',
                    'command' => null,
                    'host' => 'host',
                    'port' => 1234,
                    'timeout' => null,
                    'source_ip' => null,
                    'local_domain' => null,
                    'encryption' => null,
                    'auth_mode' => null,
                    'url' => 'smtp://user:pass@host:1234',
                ],
            ],
            [
                [
                    'url' => 'smtp://user:pass@host:1234?transport=sendmail&username=username&password=password&host=example.com&port=5678',
                ],
                [
                    'transport' => 'sendmail',
                    'username' => 'username',
                    'password' => 'password',
                    'command' => null,
                    'host' => 'example.com',
                    'port' => 5678,
                    'timeout' => null,
                    'source_ip' => null,
                    'local_domain' => null,
                    'encryption' => null,
                    'auth_mode' => null,
                    'url' => 'smtp://user:pass@host:1234?transport=sendmail&username=username&password=password&host=example.com&port=5678',
                ],
            ],
            [
                [
                    'url' => 'smtp://user:pass@host:1234?timeout=42&source_ip=source_ip&local_domain=local_domain&encryption=encryption&auth_mode=auth_mode',
                ],
                [
                    'transport' => 'smtp',
                    'username' => 'user',
                    'password' => 'pass',
                    'command' => null,
                    'host' => 'host',
                    'port' => 1234,
                    'timeout' => 42,
                    'source_ip' => 'source_ip',
                    'local_domain' => 'local_domain',
                    'encryption' => 'encryption',
                    'auth_mode' => 'auth_mode',
                    'url' => 'smtp://user:pass@host:1234?timeout=42&source_ip=source_ip&local_domain=local_domain&encryption=encryption&auth_mode=auth_mode',
                ],
            ],
            [
                [],
                [
                    'transport' => 'null',
                    'username' => null,
                    'password' => null,
                    'command' => null,
                    'host' => null,
                    'port' => 25,
                    'timeout' => null,
                    'source_ip' => null,
                    'local_domain' => null,
                    'encryption' => null,
                    'auth_mode' => null,
                ],
            ],
            [
                [
                    'transport' => 'smtp',
                ],
                [
                    'transport' => 'smtp',
                    'username' => null,
                    'password' => null,
                    'command' => null,
                    'host' => null,
                    'port' => 25,
                    'timeout' => null,
                    'source_ip' => null,
                    'local_domain' => null,
                    'encryption' => null,
                    'auth_mode' => null,
                ],
            ],
            [
                [
                    'transport' => 'gmail',
                ],
                [
                    'transport' => 'smtp',
                    'username' => null,
                    'password' => null,
                    'command' => null,
                    'host' => 'smtp.gmail.com',
                    'port' => 465,
                    'timeout' => null,
                    'source_ip' => null,
                    'local_domain' => null,
                    'encryption' => 'ssl',
                    'auth_mode' => 'login',
                ],
            ],
            [
                [
                    'transport' => 'sendmail',
                ],
                [
                    'transport' => 'sendmail',
                    'username' => null,
                    'password' => null,
                    'command' => null,
                    'host' => null,
                    'port' => 25,
                    'timeout' => null,
                    'source_ip' => null,
                    'local_domain' => null,
                    'encryption' => null,
                    'auth_mode' => null,
                ],
            ],
            [
                [
                    'encryption' => 'ssl',
                ],
                [
                    'transport' => 'null',
                    'username' => null,
                    'password' => null,
                    'command' => null,
                    'host' => null,
                    'port' => 465,
                    'timeout' => null,
                    'source_ip' => null,
                    'local_domain' => null,
                    'encryption' => 'ssl',
                    'auth_mode' => null,
                ],
            ],
            [
                [
                    'port' => 42,
                ],
                [
                    'transport' => 'null',
                    'username' => null,
                    'password' => null,
                    'command' => null,
                    'host' => null,
                    'port' => 42,
                    'timeout' => null,
                    'source_ip' => null,
                    'local_domain' => null,
                    'encryption' => null,
                    'auth_mode' => null,
                ],
            ],
        ];
    }
}
