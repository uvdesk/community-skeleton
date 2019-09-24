Lazy Collections
================

To create a lazy collection you can extend the
``Doctrine\Common\Collections\AbstractLazyCollection`` class
and define the ``doInitialize`` method. Here is an example where
we lazily query the database for a collection of user records:

.. code-block:: php
    use Doctrine\DBAL\Connection;

    class UsersLazyCollection extends AbstractLazyCollection
    {
        /** @var Connection */
        private $connection;

        public function __construct(Connection $connection)
        {
            $this->connection = $connection;
        }

        protected function doInitialize() : void
        {
            $this->collection = $this->connection->fetchAll('SELECT * FROM users');
        }
    }
