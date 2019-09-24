@Route and @Method
==================

**Routing annotations of the SensioFrameworkExtraBundle are deprecated** since
version 5.2 because they are now a core feature of Symfony.

How to Update your Applications
-------------------------------

``@Route`` Annotation
~~~~~~~~~~~~~~~~~~~~~

The Symfony ``@Route`` annotation is similar to the SensioFrameworkExtraBundle
annotation, so you only have to update the annotation class namespace:

.. code-block:: diff

    -use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    +use Symfony\Component\Routing\Annotation\Route;

    class DefaultController extends Controller
    {
        /**
         * @Route("/")
         */
        public function index()
        {
            // ...
        }
    }

The main difference is that Symfony's annotation no longer defines the
``service`` option, which was used to instantiate the controller by fetching the
given service from the container. In modern Symfony applications, all
`controllers are services by default`_ and their service IDs are their fully-
qualified class names, so this option is no longer needed.

``@Method`` Annotation
~~~~~~~~~~~~~~~~~~~~~~

The ``@Method`` annotation from SensioFrameworkExtraBundle has been removed.
Instead, the Symfony ``@Route`` annotation defines a ``methods`` option to
restrict the HTTP methods of the route:

.. code-block:: diff

    -use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    -use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    +use Symfony\Component\Routing\Annotation\Route;

    class DefaultController extends Controller
    {
        /**
    -      * @Route("/show/{id}")
    -      * @Method({"GET", "HEAD"})
    +      * @Route("/show/{id}", methods={"GET","HEAD"})
         */
        public function show($id)
        {
            // ...
        }
    }

Read the `chapter about Routing`_ in the Symfony Documentation to learn
everything about these and the other annotations available.

.. _`controllers are services by default`: https://symfony.com/doc/current/controller/service.html
.. _`chapter about Routing`: https://symfony.com/doc/current/routing.html
