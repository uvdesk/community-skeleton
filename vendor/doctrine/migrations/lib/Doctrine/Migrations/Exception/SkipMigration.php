<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Exception;

use RuntimeException;

final class SkipMigration extends RuntimeException implements ControlException
{
}
