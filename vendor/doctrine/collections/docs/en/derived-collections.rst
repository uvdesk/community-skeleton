Derived Collections
===================

You can create custom collection classes by extending the
``Doctrine\Common\Collections\ArrayCollection`` class. If the
``__construct`` semantics are different from the default ``ArrayCollection``
you can override the ``createFrom`` method:

.. code-block:: php
    final class DerivedArrayCollection extends ArrayCollection
    {
        /** @var \stdClass */
        private $foo;

        public function __construct(\stdClass $foo, array $elements = [])
        {
            $this->foo = $foo;

            parent::__construct($elements);
        }

        protected function createFrom(array $elements) : self
        {
            return new static($this->foo, $elements);
        }
    }
