<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM\Internal\Hydration;

class HydrationException extends \Doctrine\ORM\ORMException
{
    /**
     * @return HydrationException
     */
    public static function nonUniqueResult()
    {
        return new self("The result returned by the query was not unique.");
    }

    /**
     * @param string $alias
     * @param string $parentAlias
     *
     * @return HydrationException
     */
    public static function parentObjectOfRelationNotFound($alias, $parentAlias)
    {
        return new self("The parent object of entity result with alias '$alias' was not found."
            . " The parent alias is '$parentAlias'.");
    }

    /**
     * @param string $dqlAlias
     *
     * @return HydrationException
     */
    public static function emptyDiscriminatorValue($dqlAlias)
    {
        return new self("The DQL alias '" . $dqlAlias . "' contains an entity ".
            "of an inheritance hierarchy with an empty discriminator value. This means " .
            "that the database contains inconsistent data with an empty " .
            "discriminator value in a table row."
        );
    }

    /**
     * @since 2.3
     *
     * @param string $entityName
     * @param string $discrColumnName
     * @param string $dqlAlias
     *
     * @return HydrationException
     */
    public static function missingDiscriminatorColumn($entityName, $discrColumnName, $dqlAlias)
    {
        return new self(sprintf(
            'The discriminator column "%s" is missing for "%s" using the DQL alias "%s".',
            $discrColumnName, $entityName, $dqlAlias
        ));
    }

    /**
     * @since 2.3
     *
     * @param string $entityName
     * @param string $discrColumnName
     * @param string $dqlAlias
     *
     * @return HydrationException
     */
    public static function missingDiscriminatorMetaMappingColumn($entityName, $discrColumnName, $dqlAlias)
    {
        return new self(sprintf(
            'The meta mapping for the discriminator column "%s" is missing for "%s" using the DQL alias "%s".',
            $discrColumnName, $entityName, $dqlAlias
        ));
    }

    /**
     * @param string $discrValue
     * @param array  $discrMap
     *
     * @return HydrationException
     */
    public static function invalidDiscriminatorValue($discrValue, $discrMap)
    {
        return new self(sprintf(
            'The discriminator value "%s" is invalid. It must be one of "%s".',
            $discrValue, implode('", "', $discrMap)
        ));
    }
}
