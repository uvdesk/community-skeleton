Implementing the Notify ChangeTracking Policy
=============================================

.. sectionauthor:: Roman Borschel (roman@code-factory.org)

The NOTIFY change-tracking policy is the most effective
change-tracking policy provided by Doctrine but it requires some
boilerplate code. This recipe will show you how this boilerplate
code should look like. We will implement it on a
`Layer Supertype <http://martinfowler.com/eaaCatalog/layerSupertype.html>`_
for all our domain objects.

Implementing NotifyPropertyChanged
----------------------------------

The NOTIFY policy is based on the assumption that the entities
notify interested listeners of changes to their properties. For
that purpose, a class that wants to use this policy needs to
implement the ``NotifyPropertyChanged`` interface from the
``Doctrine\Common`` namespace.

.. code-block:: php

    <?php
    use Doctrine\Common\NotifyPropertyChanged;
    use Doctrine\Common\PropertyChangedListener;
    
    abstract class DomainObject implements NotifyPropertyChanged
    {
        private $listeners = array();
    
        public function addPropertyChangedListener(PropertyChangedListener $listener) {
            $this->listeners[] = $listener;
        }
    
        /** Notifies listeners of a change. */
        protected function onPropertyChanged($propName, $oldValue, $newValue) {
            if ($this->listeners) {
                foreach ($this->listeners as $listener) {
                    $listener->propertyChanged($this, $propName, $oldValue, $newValue);
                }
            }
        }
    }

Then, in each property setter of concrete, derived domain classes,
you need to invoke onPropertyChanged as follows to notify
listeners:

.. code-block:: php

    <?php
    // Mapping not shown, either in annotations, xml or yaml as usual
    class MyEntity extends DomainObject
    {
        private $data;
        // ... other fields as usual
    
        public function setData($data) {
            if ($data != $this->data) { // check: is it actually modified?
                $this->onPropertyChanged('data', $this->data, $data);
                $this->data = $data;
            }
        }
    }

The check whether the new value is different from the old one is
not mandatory but recommended. That way you can avoid unnecessary
updates and also have full control over when you consider a
property changed.


