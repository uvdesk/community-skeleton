<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex\Configurator;

use Symfony\Flex\Lock;
use Symfony\Flex\Recipe;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class MakefileConfigurator extends AbstractConfigurator
{
    public function configure(Recipe $recipe, $definitions, Lock $lock, array $options = [])
    {
        $this->write('Added Makefile entries');

        $makefile = $this->options->get('root-dir').'/Makefile';
        if (empty($options['force']) && $this->isFileMarked($recipe, $makefile)) {
            return;
        }

        $data = $this->options->expandTargetDir(implode("\n", $definitions));
        $data = $this->markData($recipe, $data);
        $data = "\n".ltrim($data, "\r\n");

        if (!file_exists($makefile)) {
            file_put_contents(
                $this->options->get('root-dir').'/Makefile',
                <<<EOF
ifndef APP_ENV
	include .env
endif

.DEFAULT_GOAL := help
.PHONY: help
help:
	@awk 'BEGIN {FS = ":.*?## "}; /^[a-zA-Z-]+:.*?## .*$$/ {printf "\033[32m%-15s\033[0m %s\\n", $$1, $$2}' Makefile | sort

EOF
            );
        }

        if (!$this->updateData($makefile, $data)) {
            file_put_contents($makefile, $data, FILE_APPEND);
        }
    }

    public function unconfigure(Recipe $recipe, $vars, Lock $lock)
    {
        if (!file_exists($makefile = $this->options->get('root-dir').'/Makefile')) {
            return;
        }

        $contents = preg_replace(sprintf('{%s*###> %s ###.*###< %s ###%s+}s', "\n", $recipe->getName(), $recipe->getName(), "\n"), "\n", file_get_contents($makefile), -1, $count);
        if (!$count) {
            return;
        }

        $this->write(sprintf('Removed Makefile entries from %s', $makefile));
        if (!trim($contents)) {
            @unlink($makefile);
        } else {
            file_put_contents($makefile, ltrim($contents, "\r\n"));
        }
    }
}
