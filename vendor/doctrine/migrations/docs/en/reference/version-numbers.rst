Version Numbers
===============

When :doc:`Generating Migrations <generating-migrations>` the newly created
classes are generated with the name ``Version{date}`` with ``{date}`` having a
``YmdHis`` `format <http://php.net/manual/en/function.date.php>`_. This format
is important as it allows the migrations to be correctly ordered.

.. note::

    Starting with version 1.5 when loading migration classes, Doctrine does a
    ``sort($versions, SORT_STRING)`` on version numbers. This can cause
    problems with custom version numbers:

.. code-block:: php

    <?php

    $versions = [
        'Version1',
        'Version2',
        // ...
        'Version10',
    ];

    sort($versions, SORT_STRING);

    var_dump($versions);

    /*
    array(3) {
      [0] =>
      string(8) "Version1"
      [1] =>
      string(9) "Version10"
      [2] =>
      string(8) "Version2"
    }
    */

The custom version numbers above end up out of order which may cause damage to a database.

It is **strongly recommended** that the ``Version{date}`` migration class name format is used and that the various
:doc:`tools for generating migrations <generating-migrations>` are used.

Should some custom migration numbers be necessary, keeping the version number the same length as the date format
(14 total characters) and padding it to the left with zeros should work.

.. code-block:: php

    <?php

    $versions = [
        'Version00000000000001',
        'Version00000000000002',
        // ...
        'Version00000000000010',
        'Version20180107070000', // generated version
    ];

    sort($versions, SORT_STRING);

    var_dump($versions);
    /*
    array(4) {
      [0] =>
      string(21) "Version00000000000001"
      [1] =>
      string(21) "Version00000000000002"
      [2] =>
      string(21) "Version00000000000010"
      [3] =>
      string(21) "Version20180107070000"
    }
    */

Please note that migrating to this new, zero-padded format may require
:ref:`manual version table intervention <managing-migrations#managing-the-version-table>` if the
versions have previously been applied.

:ref:`Next Chapter: Integrations <integrations>`
