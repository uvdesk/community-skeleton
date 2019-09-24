Working with Indexed Associations
=================================

.. note::

    This feature is available from version 2.1 of Doctrine.

Doctrine 2 collections are modelled after PHPs native arrays. PHP arrays are an ordered hashmap, but in
the first version of Doctrine keys retrieved from the database were always numerical unless ``INDEX BY``
was used. Starting with Doctrine 2.1 you can index your collections by a value in the related entity.
This is a first step towards full ordered hashmap support through the Doctrine ORM.
The feature works like an implicit ``INDEX BY`` for the selected association but has several
downsides also:

-  You have to manage both the key and field if you want to change the index by field value.
-  On each request the keys are regenerated from the field value, and not from the previous collection key.
-  Values of the Index-By keys are never considered during persistence. They only exist for accessing purposes.
-  Fields that are used for the index by feature **HAVE** to be unique in the database. The behavior for multiple entities
   with the same index-by field value is undefined.

As an example we will design a simple stock exchange list view. The domain consists of the entity ``Stock``
and ``Market`` where each Stock has a symbol and is traded on a single market. Instead of having a numerical
list of stocks traded on a market they will be indexed by their symbol, which is unique across all markets.

Mapping Indexed Associations
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You can map indexed associations by adding:

    * ``indexBy`` attribute to any ``@OneToMany`` or ``@ManyToMany`` annotation.
    * ``index-by`` attribute to any ``<one-to-many />`` or ``<many-to-many />`` xml element.
    * ``indexBy:`` key-value pair to any association defined in ``manyToMany:`` or ``oneToMany:`` YAML mapping files.

The code and mappings for the Market entity looks like this:

.. configuration-block::
    .. code-block:: php

        <?php
        namespace Doctrine\Tests\Models\StockExchange;

        use Doctrine\Common\Collections\ArrayCollection;

        /**
         * @Entity
         * @Table(name="exchange_markets")
         */
        class Market
        {
            /**
             * @Id @Column(type="integer") @GeneratedValue
             * @var int
             */
            private $id;

            /**
             * @Column(type="string")
             * @var string
             */
            private $name;

            /**
             * @OneToMany(targetEntity="Stock", mappedBy="market", indexBy="symbol")
             * @var Stock[]
             */
            private $stocks;

            public function __construct($name)
            {
                $this->name = $name;
                $this->stocks = new ArrayCollection();
            }

            public function getId()
            {
                return $this->id;
            }

            public function getName()
            {
                return $this->name;
            }

            public function addStock(Stock $stock)
            {
                $this->stocks[$stock->getSymbol()] = $stock;
            }

            public function getStock($symbol)
            {
                if (!isset($this->stocks[$symbol])) {
                    throw new \InvalidArgumentException("Symbol is not traded on this market.");
                }

                return $this->stocks[$symbol];
            }

            public function getStocks()
            {
                return $this->stocks->toArray();
            }
        }

    .. code-block:: xml

        <?xml version="1.0" encoding="UTF-8"?>
        <doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
              xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
              xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                  https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

            <entity name="Doctrine\Tests\Models\StockExchange\Market">
                <id name="id" type="integer">
                    <generator strategy="AUTO" />
                </id>

                <field name="name" type="string"/>

                <one-to-many target-entity="Stock" mapped-by="market" field="stocks" index-by="symbol" />
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        Doctrine\Tests\Models\StockExchange\Market:
          type: entity
          id:
            id:
              type: integer
              generator:
                strategy: AUTO
          fields:
            name:
              type:string
          oneToMany:
            stocks:
              targetEntity: Stock
              mappedBy: market
              indexBy: symbol

Inside the ``addStock()`` method you can see how we directly set the key of the association to the symbol,
so that we can work with the indexed association directly after invoking ``addStock()``. Inside ``getStock($symbol)``
we pick a stock traded on the particular market by symbol. If this stock doesn't exist an exception is thrown.

The ``Stock`` entity doesn't contain any special instructions that are new, but for completeness
here are the code and mappings for it:

.. configuration-block::
    .. code-block:: php

        <?php
        namespace Doctrine\Tests\Models\StockExchange;

        /**
         * @Entity
         * @Table(name="exchange_stocks")
         */
        class Stock
        {
            /**
             * @Id @GeneratedValue @Column(type="integer")
             * @var int
             */
            private $id;

            /**
             * @Column(type="string", unique=true)
             */
            private $symbol;

            /**
             * @ManyToOne(targetEntity="Market", inversedBy="stocks")
             * @var Market
             */
            private $market;

            public function __construct($symbol, Market $market)
            {
                $this->symbol = $symbol;
                $this->market = $market;
                $market->addStock($this);
            }

            public function getSymbol()
            {
                return $this->symbol;
            }
        }

    .. code-block:: xml

        <?xml version="1.0" encoding="UTF-8"?>
        <doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
              xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
              xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                  https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

            <entity name="Doctrine\Tests\Models\StockExchange\Stock">
                <id name="id" type="integer">
                    <generator strategy="AUTO" />
                </id>

                <field name="symbol" type="string" unique="true" />
                <many-to-one target-entity="Market" field="market" inversed-by="stocks" />
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        Doctrine\Tests\Models\StockExchange\Stock:
          type: entity
          id:
            id:
              type: integer
              generator:
                strategy: AUTO
          fields:
            symbol:
              type: string
          manyToOne:
            market:
              targetEntity: Market
              inversedBy: stocks

Querying indexed associations
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Now that we defined the stocks collection to be indexed by symbol, we can take a look at some code
that makes use of the indexing.

First we will populate our database with two example stocks traded on a single market:

.. code-block:: php

    <?php
    // $em is the EntityManager

    $market = new Market("Some Exchange");
    $stock1 = new Stock("AAPL", $market);
    $stock2 = new Stock("GOOG", $market);

    $em->persist($market);
    $em->persist($stock1);
    $em->persist($stock2);
    $em->flush();

This code is not particular interesting since the indexing feature is not yet used. In a new request we could
now query for the market:

.. code-block:: php

    <?php
    // $em is the EntityManager
    $marketId = 1;
    $symbol = "AAPL";
    
    $market = $em->find("Doctrine\Tests\Models\StockExchange\Market", $marketId);

    // Access the stocks by symbol now:
    $stock = $market->getStock($symbol);

    echo $stock->getSymbol(); // will print "AAPL"

The implementation of ``Market::addStock()``, in combination with ``indexBy``, allows us to access the collection
consistently by the Stock symbol. It does not matter if Stock is managed by Doctrine or not.

The same applies to DQL queries: The ``indexBy`` configuration acts as implicit "INDEX BY" to a join association.

.. code-block:: php

    <?php
    // $em is the EntityManager
    $marketId = 1;
    $symbol = "AAPL";

    $dql = "SELECT m, s FROM Doctrine\Tests\Models\StockExchange\Market m JOIN m.stocks s WHERE m.id = ?1";
    $market = $em->createQuery($dql)
                 ->setParameter(1, $marketId)
                 ->getSingleResult();

    // Access the stocks by symbol now:
    $stock = $market->getStock($symbol);

    echo $stock->getSymbol(); // will print "AAPL"

If you want to use ``INDEX BY`` explicitly on an indexed association you are free to do so. Additionally,
indexed associations also work with the ``Collection::slice()`` functionality, even if the association's fetch mode is
LAZY or EXTRA_LAZY.

Outlook into the Future
~~~~~~~~~~~~~~~~~~~~~~~

For the inverse side of a many-to-many associations there will be a way to persist the keys and the order
as a third and fourth parameter into the join table. This feature is discussed in `DDC-213 <http://www.doctrine-project.org/jira/browse/DDC-213>`_
This feature cannot be implemented for one-to-many associations, because they are never the owning side.

