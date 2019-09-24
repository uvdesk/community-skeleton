<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Exception;

use RuntimeException;

final class AbortMigration extends RuntimeException implements ControlException
{
}
