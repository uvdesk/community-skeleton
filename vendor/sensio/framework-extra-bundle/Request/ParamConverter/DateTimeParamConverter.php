<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DateTime;

/**
 * Convert DateTime instances from request attribute variable.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 */
class DateTimeParamConverter implements ParamConverterInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws NotFoundHttpException When invalid date given
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $param = $configuration->getName();

        if (!$request->attributes->has($param)) {
            return false;
        }

        $options = $configuration->getOptions();
        $value = $request->attributes->get($param);

        if (!$value && $configuration->isOptional()) {
            $request->attributes->set($param, null);

            return true;
        }

        $class = $configuration->getClass();

        if (isset($options['format'])) {
            $date = $class::createFromFormat($options['format'], $value);

            if (0 < DateTime::getLastErrors()['warning_count']) {
                $date = false;
            }

            if (!$date) {
                throw new NotFoundHttpException(sprintf('Invalid date given for parameter "%s".', $param));
            }
        } else {
            if (false === strtotime($value)) {
                throw new NotFoundHttpException(sprintf('Invalid date given for parameter "%s".', $param));
            }

            $date = new $class($value);
        }

        $request->attributes->set($param, $date);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        if (null === $configuration->getClass()) {
            return false;
        }

        return 'DateTime' === $configuration->getClass() || is_subclass_of($configuration->getClass(), \PHP_VERSION_ID < 50500 ? 'DateTime' : 'DateTimeInterface');
    }
}
