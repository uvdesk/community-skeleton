Advanced field value conversion using custom mapping types
==========================================================

.. sectionauthor:: Jan Sorgalla <jsorgalla@googlemail.com>

When creating entities, you sometimes have the need to transform field values
before they are saved to the database. In Doctrine you can use Custom Mapping 
Types to solve this (see: :ref:`reference-basic-mapping-custom-mapping-types`).

There are several ways to achieve this: converting the value inside the Type
class, converting the value on the database-level or a combination of both.

This article describes the third way by implementing the MySQL specific column
type `Point <http://dev.mysql.com/doc/refman/5.5/en/gis-class-point.html>`_.

The ``Point`` type is part of the `Spatial extension <http://dev.mysql.com/doc/refman/5.5/en/spatial-extensions.html>`_
of MySQL and enables you to store a single location in a coordinate space by
using x and y coordinates. You can use the Point type to store a 
longitude/latitude pair to represent a geographic location.

The entity
----------

We create a simple entity with a field ``$point`` which holds a value object
``Point`` representing the latitude and longitude of the position.

The entity class:

.. code-block:: php

    <?php
    
    namespace Geo\Entity;
 
    /**
     * @Entity
     */
    class Location
    {
        /**
         * @Column(type="point")
         *
         * @var \Geo\ValueObject\Point
         */
        private $point;

        /**
         * @Column(type="string")
         *
         * @var string
         */
        private $address;

        /**
         * @param \Geo\ValueObject\Point $point
         */
        public function setPoint(\Geo\ValueObject\Point $point)
        {
            $this->point = $point;
        }

        /**
         * @return \Geo\ValueObject\Point
         */
        public function getPoint()
        {
            return $this->point;
        }

        /**
         * @param string $address
         */
        public function setAddress($address)
        {
            $this->address = $address;
        }

        /**
         * @return string
         */
        public function getAddress()
        {
            return $this->address;
        }
    }

We use the custom type ``point`` in the ``@Column``  docblock annotation of the 
``$point`` field. We will create this custom mapping type in the next chapter.

The point class:

.. code-block:: php

    <?php
    
    namespace Geo\ValueObject;

    class Point
    {

        /**
         * @param float $latitude
         * @param float $longitude
         */
        public function __construct($latitude, $longitude)
        {
            $this->latitude  = $latitude;
            $this->longitude = $longitude;
        }

        /**
         * @return float
         */
        public function getLatitude()
        {
            return $this->latitude;
        }

        /**
         * @return float
         */
        public function getLongitude()
        {
            return $this->longitude;
        }
    }

The mapping type
----------------

Now we're going to create the ``point`` type and implement all required methods.

.. code-block:: php

    <?php

    namespace Geo\Types;

    use Doctrine\DBAL\Types\Type;
    use Doctrine\DBAL\Platforms\AbstractPlatform;

    use Geo\ValueObject\Point;

    class PointType extends Type
    {
        const POINT = 'point';

        public function getName()
        {
            return self::POINT;
        }

        public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
        {
            return 'POINT';
        }

        public function convertToPHPValue($value, AbstractPlatform $platform)
        {
            list($longitude, $latitude) = sscanf($value, 'POINT(%f %f)');

            return new Point($latitude, $longitude);
        }

        public function convertToDatabaseValue($value, AbstractPlatform $platform)
        {
            if ($value instanceof Point) {
                $value = sprintf('POINT(%F %F)', $value->getLongitude(), $value->getLatitude());
            }

            return $value;
        }

        public function canRequireSQLConversion()
        {
            return true;
        }

        public function convertToPHPValueSQL($sqlExpr, AbstractPlatform $platform)
        {
            return sprintf('AsText(%s)', $sqlExpr);
        }

        public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform)
        {
            return sprintf('PointFromText(%s)', $sqlExpr);
        }
    }

We do a 2-step conversion here. In the first step, we convert the ``Point``
object into a string representation before saving to the database (in the
``convertToDatabaseValue`` method) and back into an object after fetching the
value from the database (in the ``convertToPHPValue`` method).

The format of the string representation format is called `Well-known text (WKT)
<http://en.wikipedia.org/wiki/Well-known_text>`_. The advantage of this format
is, that it is both human readable and parsable by MySQL.

Internally, MySQL stores geometry values in a binary format that is not 
identical to the WKT format. So, we need to let MySQL transform the WKT
representation into its internal format.

This is where the ``convertToPHPValueSQL`` and  ``convertToDatabaseValueSQL``
methods come into play.

This methods wrap a sql expression (the WKT representation of the Point) into
MySQL functions `PointFromText <http://dev.mysql.com/doc/refman/5.5/en/creating-spatial-values.html#function_pointfromtext>`_
and `AsText <http://dev.mysql.com/doc/refman/5.5/en/functions-to-convert-geometries-between-formats.html#function_astext>`_
which convert WKT strings to and from the internal format of MySQL.

.. note::

    When using DQL queries, the ``convertToPHPValueSQL`` and  
    ``convertToDatabaseValueSQL`` methods only apply to identification variables
    and path expressions in SELECT clauses. Expressions in  WHERE clauses are 
    **not** wrapped!

    If you want to use Point values in WHERE clauses, you have to implement a
    :doc:`user defined function <dql-user-defined-functions>` for 
    ``PointFromText``.

Example usage
-------------

.. code-block:: php

    <?php

    // Bootstrapping stuff...
    // $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

    // Setup custom mapping type
    use Doctrine\DBAL\Types\Type;

    Type::addType('point', 'Geo\Types\PointType');
    $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('point', 'point');

    // Store a Location object
    use Geo\Entity\Location;
    use Geo\ValueObject\Point;

    $location = new Location();

    $location->setAddress('1600 Amphitheatre Parkway, Mountain View, CA');
    $location->setPoint(new Point(37.4220761, -122.0845187));

    $em->persist($location);
    $em->flush();
    $em->clear();

    // Fetch the Location object
    $query = $em->createQuery("SELECT l FROM Geo\Entity\Location WHERE l.address = '1600 Amphitheatre Parkway, Mountain View, CA'");
    $location = $query->getSingleResult();

    /* @var Geo\ValueObject\Point */
    $point = $location->getPoint();
