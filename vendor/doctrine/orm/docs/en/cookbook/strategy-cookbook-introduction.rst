Strategy-Pattern
================

This recipe will give you a short introduction on how to design
similar entities without using expensive (i.e. slow) inheritance
but with not more than \* the well-known strategy pattern \* event
listeners

Scenario / Problem
------------------

Given a Content-Management-System, we probably want to add / edit
some so-called "blocks" and "panels". What are they for?


-  A block might be a registration form, some text content, a table
   with information. A good example might also be a small calendar.
-  A panel is by definition a block that can itself contain blocks.
   A good example for a panel might be a sidebar box: You could easily
   add a small calendar into it.

So, in this scenario, when building your CMS, you will surely add
lots of blocks and panels to your pages and you will find yourself
highly uncomfortable because of the following:


-  Every existing page needs to know about the panels it contains -
   therefore, you'll have an association to your panels. But if you've
   got several types of panels - what do you do? Add an association to
   every panel-type? This wouldn't be flexible. You might be tempted
   to add an AbstractPanelEntity and an AbstractBlockEntity that use
   class inheritance. Your page could then only confer to the
   AbstractPanelType and Doctrine 2 would do the rest for you, i.e.
   load the right entities. But - you'll for sure have lots of panels
   and blocks, and even worse, you'd have to edit the discriminator
   map *manually* every time you or another developer implements a new
   block / entity. This would tear down any effort of modular
   programming.

Therefore, we need something that's far more flexible.

Solution
--------

The solution itself is pretty easy. We will have one base class
that will be loaded via the page and that has specific behaviour -
a Block class might render the front-end and even the backend, for
example. Now, every block that you'll write might look different or
need different data - therefore, we'll offer an API to these
methods but internally, we use a strategy that exactly knows what
to do.

First of all, we need to make sure that we have an interface that
contains every needed action. Such actions would be rendering the
front-end or the backend, solving dependencies (blocks that are
supposed to be placed in the sidebar could refuse to be placed in
the middle of your page, for example).

Such an interface could look like this:


.. code-block:: php

    <?php
    /**
     * This interface defines the basic actions that a block / panel needs to support.
     *
     * Every blockstrategy is *only* responsible for rendering a block and declaring some basic
     * support, but *not* for updating its configuration etc. For this purpose, use controllers
     * and models.
     */
    interface BlockStrategyInterface {
        /**
         * This could configure your entity
         */
        public function setConfig(Config\EntityConfig $config);

        /**
         * Returns the config this strategy is configured with.
         * @return Core\Model\Config\EntityConfig
         */
        public function getConfig();

        /**
         * Set the view object.
         * @param  \Zend_View_Interface $view
         * @return \Zend_View_Helper_Interface
         */
        public function setView(\Zend_View_Interface $view);
   
        /**
         * @return \Zend_View_Interface
         */
        public function getView();
   
        /**
         * Renders this strategy. This method will be called when the user
         * displays the site.
         *
         * @return string
         */
        public function renderFrontend();
   
        /**
         * Renders the backend of this block. This method will be called when
         * a user tries to reconfigure this block instance.
         *
         * Most of the time, this method will return / output a simple form which in turn
         * calls some controllers.
         *
         * @return string
         */
        public function renderBackend();

        /**
         * Returns all possible types of panels this block can be stacked onto
         *
         * @return array
         */
        public function getRequiredPanelTypes();
   
        /**
         * Determines whether a Block is able to use a given type or not
         * @param string $typeName The typename
         * @return boolean
         */
        public function canUsePanelType($typeName);
   
        public function setBlockEntity(AbstractBlock $block);

        public function getBlockEntity();
    }
   
As you can see, we have a method "setBlockEntity" which ties a potential strategy to an object of type AbstractBlock. This type will simply define the basic behaviour of our blocks and could potentially look something like this:
   
.. code-block:: php

    <?php
    /**
     * This is the base class for both Panels and Blocks.
     * It shouldn't be extended by your own blocks - simply write a strategy!
     */
    abstract class AbstractBlock {
        /**
         * The id of the block item instance
         * This is a doctrine field, so you need to setup generation for it
         * @var integer
         */
        private $id;

        // Add code for relation to the parent panel, configuration objects, ....

        /**
         * This var contains the classname of the strategy
         * that is used for this blockitem. (This string (!) value will be persisted by Doctrine 2)
         *
         * This is a doctrine field, so make sure that you use an @column annotation or setup your
         * yaml or xml files correctly
         * @var string
         */
        protected $strategyClassName;

        /**
         * This var contains an instance of $this->blockStrategy. Will not be persisted by Doctrine 2.
         *
         * @var BlockStrategyInterface
         */
        protected $strategyInstance;

        /**
         * Returns the strategy that is used for this blockitem.
         *
         * The strategy itself defines how this block can be rendered etc.
         *
         * @return string
         */
        public function getStrategyClassName() {
            return $this->strategyClassName;
        }
    
        /**
         * Returns the instantiated strategy
         *
         * @return BlockStrategyInterface
         */
        public function getStrategyInstance() {
            return $this->strategyInstance;
        }
    
        /**
         * Sets the strategy this block / panel should work as. Make sure that you've used
         * this method before persisting the block!
         *
         * @param BlockStrategyInterface $strategy
         */
        public function setStrategy(BlockStrategyInterface $strategy) {
            $this->strategyInstance  = $strategy;
            $this->strategyClassName = get_class($strategy);
            $strategy->setBlockEntity($this);
        }

Now, the important point is that $strategyClassName is a Doctrine 2
field, i.e. Doctrine will persist this value. This is only the
class name of your strategy and not an instance!

Finishing your strategy pattern, we hook into the Doctrine postLoad
event and check whether a block has been loaded. If so, you will
initialize it - i.e. get the strategies classname, create an
instance of it and set it via setStrategyBlock().

This might look like this:

.. code-block:: php

    <?php
    use \Doctrine\ORM,
        \Doctrine\Common;
    
    /**
     * The BlockStrategyEventListener will initialize a strategy after the
     * block itself was loaded.
     */
    class BlockStrategyEventListener implements Common\EventSubscriber {
    
        protected $view;
    
        public function __construct(\Zend_View_Interface $view) {
            $this->view = $view;
        }
    
        public function getSubscribedEvents() {
           return array(ORM\Events::postLoad);
        }
    
        public function postLoad(ORM\Event\LifecycleEventArgs $args) {
            $blockItem = $args->getEntity();
    
            // Both blocks and panels are instances of Block\AbstractBlock
            if ($blockItem instanceof Block\AbstractBlock) {
                $strategy  = $blockItem->getStrategyClassName();
                $strategyInstance = new $strategy();
                if (null !== $blockItem->getConfig()) {
                    $strategyInstance->setConfig($blockItem->getConfig());
                }
                $strategyInstance->setView($this->view);
                $blockItem->setStrategy($strategyInstance);
            }
        }
    }

In this example, even some variables are set - like a view object
or a specific configuration object.


