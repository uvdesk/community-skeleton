Separating Concerns using Embeddables
-------------------------------------

Embeddables are classes which are not entities themselves, but are embedded
in entities and can also be queried in DQL. You'll mostly want to use them
to reduce duplication or separating concerns. Value objects such as date range
or address are the primary use case for this feature. 

.. note::

    Embeddables can only contain properties with basic ``@Column`` mapping.

For the purposes of this tutorial, we will assume that you have a ``User``
class in your application and you would like to store an address in
the ``User`` class. We will model the ``Address`` class as an embeddable
instead of simply adding the respective columns to the ``User`` class.

.. configuration-block::

    .. code-block:: php

        <?php

        /** @Entity */
        class User
        {
            /** @Embedded(class = "Address") */
            private $address;
        }

        /** @Embeddable */
        class Address
        {
            /** @Column(type = "string") */
            private $street;

            /** @Column(type = "string") */
            private $postalCode;

            /** @Column(type = "string") */
            private $city;

            /** @Column(type = "string") */
            private $country;
        }

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="User">
                <embedded name="address" class="Address" />
            </entity>

            <embeddable name="Address">
                <field name="street" type="string" />
                <field name="postalCode" type="string" />
                <field name="city" type="string" />
                <field name="country" type="string" />
            </embeddable>
        </doctrine-mapping>

    .. code-block:: yaml

        User:
          type: entity
          embedded:
            address:
              class: Address

        Address:
          type: embeddable
          fields:
            street: { type: string }
            postalCode: { type: string }
            city: { type: string }
            country: { type: string }

In terms of your database schema, Doctrine will automatically inline all
columns from the ``Address`` class into the table of the ``User`` class,
just as if you had declared them directly there.

Initializing embeddables
------------------------

In case all fields in the embeddable are ``nullable``, you might want
to initialize the embeddable, to avoid getting a null value instead of
the embedded object.

.. code-block:: php

    public function __construct()
    {
        $this->address = new Address();
    }

Column Prefixing
----------------

By default, Doctrine names your columns by prefixing them, using the value
object name.

Following the example above, your columns would be named as ``address_street``,
``address_postalCode``...

You can change this behaviour to meet your needs by changing the
``columnPrefix`` attribute in the ``@Embedded`` notation.

The following example shows you how to set your prefix to ``myPrefix_``:

.. configuration-block::

    .. code-block:: php

        <?php

        /** @Entity */
        class User
        {
            /** @Embedded(class = "Address", columnPrefix = "myPrefix_") */
            private $address;
        }

    .. code-block:: xml

        <entity name="User">
            <embedded name="address" class="Address" column-prefix="myPrefix_" />
        </entity>

    .. code-block:: yaml

        User:
          type: entity
          embedded:
            address:
              class: Address
              columnPrefix: myPrefix_

To have Doctrine drop the prefix and use the value object's property name
directly, set ``columnPrefix=false`` (``use-column-prefix="false"`` for XML):

.. configuration-block::

    .. code-block:: php

        <?php

        /** @Entity */
        class User
        {
            /** @Embedded(class = "Address", columnPrefix = false) */
            private $address;
        }

    .. code-block:: yaml

        User:
          type: entity
          embedded:
            address:
              class: Address
              columnPrefix: false

    .. code-block:: xml

        <entity name="User">
            <embedded name="address" class="Address" use-column-prefix="false" />
        </entity>


DQL
---

You can also use mapped fields of embedded classes in DQL queries, just
as if they were declared in the ``User`` class:

.. code-block:: sql

    SELECT u FROM User u WHERE u.address.city = :myCity

