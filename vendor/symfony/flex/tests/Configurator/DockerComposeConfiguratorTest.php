<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex\Tests\Configurator;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\Package;
use PHPUnit\Framework\TestCase;
use Symfony\Flex\Configurator\DockerComposeConfigurator;
use Symfony\Flex\Lock;
use Symfony\Flex\Options;
use Symfony\Flex\Recipe;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class DockerComposeConfiguratorTest extends TestCase
{
    const ORIGINAL_CONTENT = <<<'YAML'
version: '3.4'

services:
  app:
    build:
      context: .
      target: symfony_docker_php
      args:
        SYMFONY_VERSION: ${SYMFONY_VERSION:-}
        STABILITY: ${STABILITY:-stable}
    volumes:
      # Comment out the next line in production
      - ./:/srv/app:rw,cached
      # If you develop on Linux, comment out the following volumes to just use bind-mounted project directory from host
      - /srv/app/var/
      - /srv/app/var/cache/
      - /srv/app/var/logs/
      - /srv/app/var/sessions/
    environment:
      - SYMFONY_VERSION

  nginx:
    build:
      context: .
      target: symfony_docker_nginx
    depends_on:
      - app
    volumes:
      # Comment out the next line in production
      - ./docker/nginx/conf.d:/etc/nginx/conf.d:ro
      - ./public:/srv/app/public:ro
    ports:
      - '80:80'

  # This HTTP/2 proxy is not secure: it should only be used in dev
  h2-proxy:
    build:
      context: .
      target: symfony_docker_h2-proxy
    depends_on:
      - nginx
    volumes:
      - ./docker/h2-proxy/default.conf:/etc/nginx/conf.d/default.conf:ro
    ports:
      - '443:443'

YAML;

    const CONFIG_DB = [
        'services' => [
            'db:',
            '  image: mariadb:10.3',
            '  environment:',
            '    - MYSQL_DATABASE=symfony',
            '    # You should definitely change the password in production',
            '    - MYSQL_PASSWORD=password',
            '    - MYSQL_RANDOM_ROOT_PASSWORD=true',
            '    - MYSQL_USER=symfony',
            '  volumes:',
            '    - db-data:/var/lib/mysql:rw',
            '    # You may use a bind-mounted host directory instead, so that it is harder to accidentally remove the volume and lose all your data!',
            '    # - ./docker/db/data:/var/lib/mysql:rw',
        ],
        'volumes' => ['db-data: {}'],
    ];

    /** @var Recipe|\PHPUnit\Framework\MockObject\MockObject */
    private $recipeDb;

    /** @var Lock|\PHPUnit\Framework\MockObject\MockObject */
    private $lock;

    /** @var DockerComposeConfigurator */
    private $configurator;

    public function setUp(string $name = null, array $data = [], string $dataName = '')
    {
        @mkdir(FLEX_TEST_DIR);

        // Recipe
        $this->recipeDb = $this->getMockBuilder(Recipe::class)->disableOriginalConstructor()->getMock();
        $this->recipeDb->method('getName')->willReturn('doctrine/doctrine-bundle');

        // Lock
        $this->lock = $this->getMockBuilder(Lock::class)->disableOriginalConstructor()->getMock();

        // Configurator
        $package = new Package('dummy/dummy', '1.0.0', '1.0.0');
        $package->setExtra(['symfony' => ['docker' => true]]);

        $composer = $this->getMockBuilder(Composer::class)->getMock();
        $composer->method('getPackage')->willReturn($package);

        $this->configurator = new DockerComposeConfigurator(
            $composer,
            $this->getMockBuilder(IOInterface::class)->getMock(),
            new Options(['config-dir' => 'config', 'root-dir' => FLEX_TEST_DIR])
        );
    }

    protected function tearDown()
    {
        @unlink(FLEX_TEST_DIR.'/docker-compose.yml');
        @unlink(FLEX_TEST_DIR.'/docker-compose.yaml');
    }

    public function testConfigure()
    {
        $dockerComposeFile = FLEX_TEST_DIR.'/docker-compose.yaml';
        file_put_contents($dockerComposeFile, self::ORIGINAL_CONTENT);

        $this->configurator->configure($this->recipeDb, self::CONFIG_DB, $this->lock);

        $this->assertEquals(self::ORIGINAL_CONTENT.<<<'YAML'

###> doctrine/doctrine-bundle ###
  db:
    image: mariadb:10.3
    environment:
      - MYSQL_DATABASE=symfony
      # You should definitely change the password in production
      - MYSQL_PASSWORD=password
      - MYSQL_RANDOM_ROOT_PASSWORD=true
      - MYSQL_USER=symfony
    volumes:
      - db-data:/var/lib/mysql:rw
      # You may use a bind-mounted host directory instead, so that it is harder to accidentally remove the volume and lose all your data!
      # - ./docker/db/data:/var/lib/mysql:rw
###< doctrine/doctrine-bundle ###

volumes:
###> doctrine/doctrine-bundle ###
  db-data: {}
###< doctrine/doctrine-bundle ###

YAML
            , file_get_contents($dockerComposeFile));

        $this->configurator->unconfigure($this->recipeDb, self::CONFIG_DB, $this->lock);
        $this->assertEquals(self::ORIGINAL_CONTENT, file_get_contents($dockerComposeFile));
    }

    public function testConfigureFileWithExistingVolumes()
    {
        $originalContent = self::ORIGINAL_CONTENT.<<<'YAML'

volumes:
  my-data: {}

YAML;

        $dockerComposeFile = FLEX_TEST_DIR.'/docker-compose.yaml';
        file_put_contents($dockerComposeFile, $originalContent);

        $this->configurator->configure($this->recipeDb, self::CONFIG_DB, $this->lock);

        $this->assertEquals(self::ORIGINAL_CONTENT.<<<'YAML'

###> doctrine/doctrine-bundle ###
  db:
    image: mariadb:10.3
    environment:
      - MYSQL_DATABASE=symfony
      # You should definitely change the password in production
      - MYSQL_PASSWORD=password
      - MYSQL_RANDOM_ROOT_PASSWORD=true
      - MYSQL_USER=symfony
    volumes:
      - db-data:/var/lib/mysql:rw
      # You may use a bind-mounted host directory instead, so that it is harder to accidentally remove the volume and lose all your data!
      # - ./docker/db/data:/var/lib/mysql:rw
###< doctrine/doctrine-bundle ###

volumes:
  my-data: {}

###> doctrine/doctrine-bundle ###
  db-data: {}
###< doctrine/doctrine-bundle ###

YAML
            , file_get_contents($dockerComposeFile));

        $this->configurator->unconfigure($this->recipeDb, self::CONFIG_DB, $this->lock);
        // Not the same original, we have an extra breaks line
        $this->assertEquals($originalContent.<<<'YAML'


YAML
            , file_get_contents($dockerComposeFile));
    }

    public function testConfigureFileWithExistingMarks()
    {
        $originalContent = self::ORIGINAL_CONTENT.<<<'YAML'

###> doctrine/doctrine-bundle ###
  db:
    image: postgres:11-alpine
    environment:
      - POSTGRES_DB=symfony
      - POSTGRES_USER=symfony
      # You should definitely change the password in production
      - POSTGRES_PASSWORD=!ChangeMe!
    volumes:
      - db-data:/var/lib/postgresql/data:rw
      # You may use a bind-mounted host directory instead, so that it is harder to accidentally remove the volume and lose all your data!
      # - ./docker/db/data:/var/lib/postgresql/data:rw
    ports:
      - "5432:5432"
###< doctrine/doctrine-bundle ###

volumes:
###> doctrine/doctrine-bundle ###
  db-data: {}
###< doctrine/doctrine-bundle ###

YAML;

        $recipe = $this->getMockBuilder(Recipe::class)->disableOriginalConstructor()->getMock();
        $recipe->method('getName')->willReturn('symfony/mercure-bundle');

        $dockerComposeFile = FLEX_TEST_DIR.'/docker-compose.yml';
        file_put_contents($dockerComposeFile, $originalContent);

        /** @var Recipe|\PHPUnit\Framework\MockObject\MockObject $recipe */
        $recipe = $this->getMockBuilder(Recipe::class)->disableOriginalConstructor()->getMock();
        $recipe->method('getName')->willReturn('symfony/mercure-bundle');

        $config = [
            'services' => [
                'mercure:',
                '  # In production, you may want to use the managed version of Mercure, https://mercure.rocks',
                '  image: dunglas/mercure',
                '  environment:',
                '    # You should definitely change all these values in production',
                '    - JWT_KEY=!ChangeMe!',
                '    - ALLOW_ANONYMOUS=1',
                '    - CORS_ALLOWED_ORIGINS=*',
                '    - PUBLISH_ALLOWED_ORIGINS=http://localhost:1337',
                '    - DEMO=1',
                '  ports:',
                '    - "1337:80"',
            ],
        ];

        $this->configurator->configure($recipe, $config, $this->lock);

        $this->assertEquals(self::ORIGINAL_CONTENT.<<<'YAML'

###> doctrine/doctrine-bundle ###
  db:
    image: postgres:11-alpine
    environment:
      - POSTGRES_DB=symfony
      - POSTGRES_USER=symfony
      # You should definitely change the password in production
      - POSTGRES_PASSWORD=!ChangeMe!
    volumes:
      - db-data:/var/lib/postgresql/data:rw
      # You may use a bind-mounted host directory instead, so that it is harder to accidentally remove the volume and lose all your data!
      # - ./docker/db/data:/var/lib/postgresql/data:rw
    ports:
      - "5432:5432"
###< doctrine/doctrine-bundle ###

###> symfony/mercure-bundle ###
  mercure:
    # In production, you may want to use the managed version of Mercure, https://mercure.rocks
    image: dunglas/mercure
    environment:
      # You should definitely change all these values in production
      - JWT_KEY=!ChangeMe!
      - ALLOW_ANONYMOUS=1
      - CORS_ALLOWED_ORIGINS=*
      - PUBLISH_ALLOWED_ORIGINS=http://localhost:1337
      - DEMO=1
    ports:
      - "1337:80"
###< symfony/mercure-bundle ###

volumes:
###> doctrine/doctrine-bundle ###
  db-data: {}
###< doctrine/doctrine-bundle ###

YAML
            , file_get_contents($dockerComposeFile));

        $this->configurator->unconfigure($recipe, $config, $this->lock);
        $this->assertEquals($originalContent, file_get_contents($dockerComposeFile));

        // Unconfigure doctrine
        $this->configurator->unconfigure($this->recipeDb, self::CONFIG_DB, $this->lock);
        $this->assertEquals(self::ORIGINAL_CONTENT, file_get_contents($dockerComposeFile));
    }
}
