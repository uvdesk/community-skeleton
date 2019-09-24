<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Exception;

use RuntimeException;

final class IrreversibleMigration extends RuntimeException implements MigrationException
{
}
