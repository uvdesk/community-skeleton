<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Fixtures\FooBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Used in the function test IsGrantedTest.
 */
class IsGrantedVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return 'ISGRANTED_VOTER' === $attribute;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // we use these specific conditions in the test
        if ('allow_access' === $subject) {
            return true;
        }

        if ($subject instanceof Request) {
            return true;
        }

        if (['foo', 'bar'] === $subject) {
            return true;
        }

        return false;
    }
}
