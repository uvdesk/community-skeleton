<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Flex\Cache;

class CacheTest extends TestCase
{
    /**
     * @dataProvider provideRemoveLegacyTags
     */
    public function testRemoveLegacyTags(array $expected, array $packages, string $symfonyRequire, array $versions)
    {
        $downloader = $this->getMockBuilder('Symfony\Flex\Downloader')->disableOriginalConstructor()->getMock();
        $downloader->expects($this->once())
            ->method('getVersions')
            ->willReturn($versions);
        $cache = (new \ReflectionClass(Cache::class))->newInstanceWithoutConstructor();
        $cache->setSymfonyRequire($symfonyRequire, $downloader);

        $this->assertSame(['packages' => $expected], $cache->removeLegacyTags(['packages' => $packages]));
    }

    public function provideRemoveLegacyTags()
    {
        yield 'no-symfony/symfony' => [[123], [123], '~1', ['splits' => []]];

        $branchAlias = function ($versionAlias) {
            return [
                'extra' => [
                    'branch-alias' => [
                        'dev-master' => $versionAlias.'-dev',
                    ],
                ],
            ];
        };

        $packages = [
            'foo/unrelated' => [
                '1.0.0' => [],
            ],
            'symfony/symfony' => [
                '3.3.0' => [
                    'version_normalized' => '3.3.0.0',
                ],
                '3.4.0' => [
                    'version_normalized' => '3.4.0.0',
                ],
                'dev-master' => $branchAlias('3.5'),
            ],
            'symfony/foo' => [
                '3.3.0' => ['version_normalized' => '3.3.0.0'],
                '3.4.0' => ['version_normalized' => '3.4.0.0'],
                'dev-master' => $branchAlias('3.5'),
            ],
        ];

        yield 'empty-intersection-ignores' => [$packages, $packages, '~2.0', ['splits' => [
            'symfony/foo' => ['3.3', '3.4', '3.5'],
        ]]];
        yield 'empty-intersection-ignores' => [$packages, $packages, '~4.0', ['splits' => [
            'symfony/foo' => ['3.3', '3.4', '3.5'],
        ]]];

        $expected = $packages;
        unset($expected['symfony/symfony']['3.3.0']);
        unset($expected['symfony/foo']['3.3.0']);

        yield 'non-empty-intersection-filters' => [$expected, $packages, '~3.4', ['splits' => [
            'symfony/foo' => ['3.3', '3.4', '3.5'],
        ]]];

        unset($expected['symfony/symfony']['3.4.0']);
        unset($expected['symfony/foo']['3.4.0']);

        yield 'master-only' => [$expected, $packages, '~3.5', ['splits' => [
            'symfony/foo' => ['3.4', '3.5'],
        ]]];

        $packages = [
            'symfony/symfony' => [
                '2.8.0' => [
                    'version_normalized' => '2.8.0.0',
                ],
            ],
            'symfony/legacy' => [
                '2.8.0' => ['version_normalized' => '2.8.0.0'],
                'dev-master' => $branchAlias('2.8'),
            ],
        ];

        yield 'legacy-are-not-filtered' => [$packages, $packages, '~3.0', ['splits' => [
            'symfony/legacy' => ['2.8'],
            'symfony/foo' => ['2.8'],
        ]]];

        $packages = [
            'symfony/symfony' => [
                '2.8.0' => [
                    'version_normalized' => '2.8.0.0',
                ],
                'dev-master' => $branchAlias('3.0'),
            ],
            'symfony/foo' => [
                '2.8.0' => ['version_normalized' => '2.8.0.0'],
                'dev-master' => $branchAlias('3.0'),
            ],
            'symfony/new' => [
                'dev-master' => $branchAlias('3.0'),
            ],
        ];

        $expected = $packages;
        unset($expected['symfony/symfony']['dev-master']);
        unset($expected['symfony/foo']['dev-master']);

        yield 'master-is-filtered-only-when-in-range' => [$expected, $packages, '~2.8', ['splits' => [
            'symfony/foo' => ['2.8', '3.0'],
            'symfony/new' => ['3.0'],
        ]]];
    }
}
