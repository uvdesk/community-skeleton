Ordering To-Many Associations
-----------------------------

There are use-cases when you'll want to sort collections when they are
retrieved from the database. In userland you do this as long as you
haven't initially saved an entity with its associations into the
database. To retrieve a sorted collection from the database you can
use the ``@OrderBy`` annotation with an collection that specifies
an DQL snippet that is appended to all queries with this
collection.

Additional to any ``@OneToMany`` or ``@ManyToMany`` annotation you
can specify the ``@OrderBy`` in the following way:

.. configuration-block::

    .. code-block:: php

        <?php
        /** @Entity **/
        class User
        {
            // ...
        
            /**
             * @ManyToMany(targetEntity="Group")
             * @OrderBy({"name" = "ASC"})
             **/
            private $groups;
        }

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="User">
                <many-to-many field="groups" target-entity="Group">
                    <order-by>
                        <order-by-field name="name" direction="ASC" />
                    </order-by>
                </many-to-many>
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        User:
          type: entity
          manyToMany:
            groups:
              orderBy: { 'name': 'ASC' }
              targetEntity: Group
              joinTable:
                name: users_groups
                joinColumns:
                  user_id:
                    referencedColumnName: id
                inverseJoinColumns:
                  group_id:
                    referencedColumnName: id

The DQL Snippet in OrderBy is only allowed to consist of
unqualified, unquoted field names and of an optional ASC/DESC
positional statement. Multiple Fields are separated by a comma (,).
The referenced field names have to exist on the ``targetEntity``
class of the ``@ManyToMany`` or ``@OneToMany`` annotation.

The semantics of this feature can be described as follows.


-  ``@OrderBy`` acts as an implicit ORDER BY clause for the given
   fields, that is appended to all the explicitly given ORDER BY
   items.
-  All collections of the ordered type are always retrieved in an
   ordered fashion.
-  To keep the database impact low, these implicit ORDER BY items
   are only added to an DQL Query if the collection is fetch joined in
   the DQL query.

Given our previously defined example, the following would not add
ORDER BY, since g is not fetch joined:

.. code-block:: sql

    SELECT u FROM User u JOIN u.groups g WHERE SIZE(g) > 10

However the following:

.. code-block:: sql

    SELECT u, g FROM User u JOIN u.groups g WHERE u.id = 10

...would internally be rewritten to:

.. code-block:: sql

    SELECT u, g FROM User u JOIN u.groups g WHERE u.id = 10 ORDER BY g.name ASC

You can reverse the order with an explicit DQL ORDER BY:

.. code-block:: sql

    SELECT u, g FROM User u JOIN u.groups g WHERE u.id = 10 ORDER BY g.name DESC

...is internally rewritten to:

.. code-block:: sql

    SELECT u, g FROM User u JOIN u.groups g WHERE u.id = 10 ORDER BY g.name DESC, g.name ASC


