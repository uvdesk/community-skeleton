Keeping your Modules independent
=================================

.. versionadded:: 2.2

One of the goals of using modules is to create discrete units of functionality
that do not have many (if any) dependencies, allowing you to use that
functionality in other applications without including unnecessary items.

Doctrine 2.2 includes a new utility called the ``ResolveTargetEntityListener``,
that functions by intercepting certain calls inside Doctrine and rewrite
targetEntity parameters in your metadata mapping at runtime. It means that
in your bundle you are able to use an interface or abstract class in your
mappings and expect correct mapping to a concrete entity at runtime.

This functionality allows you to define relationships between different entities
but not making them hard dependencies.

Background
----------

In the following example, the situation is we have an `InvoiceModule`
which provides invoicing functionality, and a `CustomerModule` that
contains customer management tools. We want to keep these separated,
because they can be used in other systems without each other, but for
our application we want to use them together.

In this case, we have an ``Invoice`` entity with a relationship to a
non-existent object, an ``InvoiceSubjectInterface``. The goal is to get
the ``ResolveTargetEntityListener`` to replace any mention of the interface
with a real object that implements that interface.

Set up
------

We're going to use the following basic entities (which are incomplete
for brevity) to explain how to set up and use the RTEL.

A Customer entity

.. code-block:: php

    <?php
    // src/Acme/AppModule/Entity/Customer.php

    namespace Acme\AppModule\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Acme\CustomerModule\Entity\Customer as BaseCustomer;
    use Acme\InvoiceModule\Model\InvoiceSubjectInterface;

    /**
     * @ORM\Entity
     * @ORM\Table(name="customer")
     */
    class Customer extends BaseCustomer implements InvoiceSubjectInterface
    {
        // In our example, any methods defined in the InvoiceSubjectInterface
        // are already implemented in the BaseCustomer
    }

An Invoice entity

.. code-block:: php

    <?php
    // src/Acme/InvoiceModule/Entity/Invoice.php

    namespace Acme\InvoiceModule\Entity;

    use Doctrine\ORM\Mapping AS ORM;
    use Acme\InvoiceModule\Model\InvoiceSubjectInterface;

    /**
     * Represents an Invoice.
     *
     * @ORM\Entity
     * @ORM\Table(name="invoice")
     */
    class Invoice
    {
        /**
         * @ORM\ManyToOne(targetEntity="Acme\InvoiceModule\Model\InvoiceSubjectInterface")
         * @var InvoiceSubjectInterface
         */
        protected $subject;
    }

An InvoiceSubjectInterface

.. code-block:: php

    <?php
    // src/Acme/InvoiceModule/Model/InvoiceSubjectInterface.php

    namespace Acme\InvoiceModule\Model;

    /**
     * An interface that the invoice Subject object should implement.
     * In most circumstances, only a single object should implement
     * this interface as the ResolveTargetEntityListener can only
     * change the target to a single object.
     */
    interface InvoiceSubjectInterface
    {
        // List any additional methods that your InvoiceModule
        // will need to access on the subject so that you can
        // be sure that you have access to those methods.

        /**
         * @return string
         */
        public function getName();
    }

Next, we need to configure the listener. Add this to the area you set up Doctrine. You
must set this up in the way outlined below, otherwise you can not be guaranteed that
the targetEntity resolution will occur reliably:

.. code-block:: php

    <?php
    $evm  = new \Doctrine\Common\EventManager;
    $rtel = new \Doctrine\ORM\Tools\ResolveTargetEntityListener;

    // Adds a target-entity class
    $rtel->addResolveTargetEntity('Acme\\InvoiceModule\\Model\\InvoiceSubjectInterface', 'Acme\\CustomerModule\\Entity\\Customer', array());

    // Add the ResolveTargetEntityListener
    $evm->addEventListener(Doctrine\ORM\Events::loadClassMetadata, $rtel);

    $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config, $evm);

Final Thoughts
--------------

With the ``ResolveTargetEntityListener``, we are able to decouple our
bundles, keeping them usable by themselves, but still being able to
define relationships between different objects. By using this method,
I've found my bundles end up being easier to maintain independently.


