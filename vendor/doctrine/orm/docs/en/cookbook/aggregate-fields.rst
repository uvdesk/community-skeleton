Aggregate Fields
================

.. sectionauthor:: Benjamin Eberlei <kontakt@beberlei.de>

You will often come across the requirement to display aggregate
values of data that can be computed by using the MIN, MAX, COUNT or
SUM SQL functions. For any ORM this is a tricky issue
traditionally. Doctrine 2 offers several ways to get access to
these values and this article will describe all of them from
different perspectives.

You will see that aggregate fields can become very explicit
features in your domain model and how this potentially complex
business rules can be easily tested.

An example model
----------------

Say you want to model a bank account and all their entries. Entries
into the account can either be of positive or negative money
values. Each account has a credit limit and the account is never
allowed to have a balance below that value.

For simplicity we live in a world were money is composed of
integers only. Also we omit the receiver/sender name, stated reason
for transfer and the execution date. These all would have to be
added on the ``Entry`` object.

Our entities look like:

.. code-block:: php

    <?php
    namespace Bank\Entities;
    
    /**
     * @Entity
     */
    class Account
    {
        /** @Id @GeneratedValue @Column(type="integer") */
        private $id;
    
        /** @Column(type="string", unique=true) */
        private $no;
    
        /**
         * @OneToMany(targetEntity="Entry", mappedBy="account", cascade={"persist"})
         */
        private $entries;
    
        /**
         * @Column(type="integer")
         */
        private $maxCredit = 0;
    
        public function __construct($no, $maxCredit = 0)
        {
            $this->no = $no;
            $this->maxCredit = $maxCredit;
            $this->entries = new \Doctrine\Common\Collections\ArrayCollection();
        }
    }
    
    /**
     * @Entity
     */
    class Entry
    {
        /** @Id @GeneratedValue @Column(type="integer") */
        private $id;
    
        /**
         * @ManyToOne(targetEntity="Account", inversedBy="entries")
         */
        private $account;
    
        /**
         * @Column(type="integer")
         */
        private $amount;
    
        public function __construct($account, $amount)
        {
            $this->account = $account;
            $this->amount = $amount;
            // more stuff here, from/to whom, stated reason, execution date and such
        }
    
        public function getAmount()
        {
            return $this->amount;
        }
    }

Using DQL
---------

The Doctrine Query Language allows you to select for aggregate
values computed from fields of your Domain Model. You can select
the current balance of your account by calling:

.. code-block:: php

    <?php
    $dql = "SELECT SUM(e.amount) AS balance FROM Bank\Entities\Entry e " .
           "WHERE e.account = ?1";
    $balance = $em->createQuery($dql)
                  ->setParameter(1, $myAccountId)
                  ->getSingleScalarResult();

The ``$em`` variable in this (and forthcoming) example holds the
Doctrine ``EntityManager``. We create a query for the SUM of all
amounts (negative amounts are withdraws) and retrieve them as a
single scalar result, essentially return only the first column of
the first row.

This approach is simple and powerful, however it has a serious
drawback. We have to execute a specific query for the balance
whenever we need it.

To implement a powerful domain model we would rather have access to
the balance from our ``Account`` entity during all times (even if
the Account was not persisted in the database before!).

Also an additional requirement is the max credit per ``Account``
rule.

We cannot reliably enforce this rule in our ``Account`` entity with
the DQL retrieval of the balance. There are many different ways to
retrieve accounts. We cannot guarantee that we can execute the
aggregation query for all these use-cases, let alone that a
userland programmer checks this balance against newly added
entries.

Using your Domain Model
-----------------------

``Account`` and all the ``Entry`` instances are connected through a
collection, which means we can compute this value at runtime:

.. code-block:: php

    <?php
    class Account
    {
        // .. previous code
        public function getBalance()
        {
            $balance = 0;
            foreach ($this->entries as $entry) {
                $balance += $entry->getAmount();
            }
            return $balance;
        }
    }

Now we can always call ``Account::getBalance()`` to access the
current account balance.

To enforce the max credit rule we have to implement the "Aggregate
Root" pattern as described in Eric Evans book on Domain Driven
Design. Described with one sentence, an aggregate root controls the
instance creation, access and manipulation of its children.

In our case we want to enforce that new entries can only added to
the ``Account`` by using a designated method. The ``Account`` is
the aggregate root of this relation. We can also enforce the
correctness of the bi-directional ``Account`` <-> ``Entry``
relation with this method:

.. code-block:: php

    <?php
    class Account
    {
        public function addEntry($amount)
        {
            $this->assertAcceptEntryAllowed($amount);
    
            $e = new Entry($this, $amount);
            $this->entries[] = $e;
            return $e;
        }
    }

Now look at the following test-code for our entities:

.. code-block:: php

    <?php
    class AccountTest extends \PHPUnit_Framework_TestCase
    {
        public function testAddEntry()
        {
            $account = new Account("123456", $maxCredit = 200);
            $this->assertEquals(0, $account->getBalance());
    
            $account->addEntry(500);
            $this->assertEquals(500, $account->getBalance());
    
            $account->addEntry(-700);
            $this->assertEquals(-200, $account->getBalance());
        }
    
        public function testExceedMaxLimit()
        {
            $account = new Account("123456", $maxCredit = 200);
    
            $this->setExpectedException("Exception");
            $account->addEntry(-1000);
        }
    }

To enforce our rule we can now implement the assertion in
``Account::addEntry``:

.. code-block:: php

    <?php
    class Account
    {
        private function assertAcceptEntryAllowed($amount)
        {
            $futureBalance = $this->getBalance() + $amount;
            $allowedMinimalBalance = ($this->maxCredit * -1);
            if ($futureBalance < $allowedMinimalBalance) {
                throw new Exception("Credit Limit exceeded, entry is not allowed!");
            }
        }
    }

We haven't talked to the entity manager for persistence of our
account example before. You can call
``EntityManager::persist($account)`` and then
``EntityManager::flush()`` at any point to save the account to the
database. All the nested ``Entry`` objects are automatically
flushed to the database also.

.. code-block:: php

    <?php
    $account = new Account("123456", 200);
    $account->addEntry(500);
    $account->addEntry(-200);
    $em->persist($account);
    $em->flush();

The current implementation has a considerable drawback. To get the
balance, we have to initialize the complete ``Account::$entries``
collection, possibly a very large one. This can considerably hurt
the performance of your application.

Using an Aggregate Field
------------------------

To overcome the previously mentioned issue (initializing the whole
entries collection) we want to add an aggregate field called
"balance" on the Account and adjust the code in
``Account::getBalance()`` and ``Account:addEntry()``:

.. code-block:: php

    <?php
    class Account
    {
        /**
         * @Column(type="integer")
         */
        private $balance = 0;
    
        public function getBalance()
        {
            return $this->balance;
        }
    
        public function addEntry($amount)
        {
            $this->assertAcceptEntryAllowed($amount);
    
            $e = new Entry($this, $amount);
            $this->entries[] = $e;
            $this->balance += $amount;
            return $e;
        }
    }

This is a very simple change, but all the tests still pass. Our
account entities return the correct balance. Now calling the
``Account::getBalance()`` method will not occur the overhead of
loading all entries anymore. Adding a new Entry to the
``Account::$entities`` will also not initialize the collection
internally.

Adding a new entry is therefore very performant and explicitly
hooked into the domain model. It will only update the account with
the current balance and insert the new entry into the database.

Tackling Race Conditions with Aggregate Fields
----------------------------------------------

Whenever you denormalize your database schema race-conditions can
potentially lead to inconsistent state. See this example:

.. code-block:: php

    <?php
    // The Account $accId has a balance of 0 and a max credit limit of 200:
    // request 1 account
    $account1 = $em->find('Bank\Entities\Account', $accId);
    
    // request 2 account
    $account2 = $em->find('Bank\Entities\Account', $accId);
    
    $account1->addEntry(-200);
    $account2->addEntry(-200);
    
    // now request 1 and 2 both flush the changes.

The aggregate field ``Account::$balance`` is now -200, however the
SUM over all entries amounts yields -400. A violation of our max
credit rule.

You can use both optimistic or pessimistic locking to safe-guard
your aggregate fields against this kind of race-conditions. Reading
Eric Evans DDD carefully he mentions that the "Aggregate Root"
(Account in our example) needs a locking mechanism.

Optimistic locking is as easy as adding a version column:

.. code-block:: php

    <?php
    class Account
    {
        /** @Column(type="integer") @Version */
        private $version;
    }

The previous example would then throw an exception in the face of
whatever request saves the entity last (and would create the
inconsistent state).

Pessimistic locking requires an additional flag set on the
``EntityManager::find()`` call, enabling write locking directly in
the database using a FOR UPDATE.

.. code-block:: php

    <?php
    use Doctrine\DBAL\LockMode;
    
    $account = $em->find('Bank\Entities\Account', $accId, LockMode::PESSIMISTIC_READ);

Keeping Updates and Deletes in Sync
-----------------------------------

The example shown in this article does not allow changes to the
value in ``Entry``, which considerably simplifies the effort to
keep ``Account::$balance`` in sync. If your use-case allows fields
to be updated or related entities to be removed you have to
encapsulate this logic in your "Aggregate Root" entity and adjust
the aggregate field accordingly.

Conclusion
----------

This article described how to obtain aggregate values using DQL or
your domain model. It showed how you can easily add an aggregate
field that offers serious performance benefits over iterating all
the related objects that make up an aggregate value. Finally I
showed how you can ensure that your aggregate fields do not get out
of sync due to race-conditions and concurrent access.


