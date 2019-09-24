@ParamConverter
===============

Usage
-----

The ``@ParamConverter`` annotation calls *converters* to convert request
parameters to objects. These objects are stored as request attributes and so
they can be injected as controller method arguments::

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

    /**
     * @Route("/blog/{id}")
     * @ParamConverter("post", class="SensioBlogBundle:Post")
     */
    public function show(Post $post)
    {
    }

Several things happen under the hood:

* The converter tries to get a ``SensioBlogBundle:Post`` object from the
  request attributes (request attributes comes from route placeholders -- here
  ``id``);

* If no ``Post`` object is found, a ``404`` Response is generated;

* If a ``Post`` object is found, a new ``post`` request attribute is defined
  (accessible via ``$request->attributes->get('post')``);

* As for other request attributes, it is automatically injected in the
  controller when present in the method signature.

If you use type hinting as in the example above, you can even omit the
``@ParamConverter`` annotation altogether::

    // automatic with method signature
    public function show(Post $post)
    {
    }

You can disable the auto-conversion of type-hinted method arguments feature
by setting the ``auto_convert`` flag to ``false``:

.. configuration-block::

    .. code-block:: yaml

        # app/config/config.yml
        sensio_framework_extra:
            request:
                converters: true
                auto_convert: false

    .. code-block:: xml

        <sensio-framework-extra:config>
            <request converters="true" auto-convert="true" />
        </sensio-framework-extra:config>

You can also explicitly disable some converters by name:

.. configuration-block::

    .. code-block:: yaml

        # app/config/config.yml
        sensio_framework_extra:
            request:
                converters: true
                disable: ['doctrine.orm', 'datetime']

    .. code-block:: xml

        <sensio-framework-extra:config>
            <request converters="true" disable="doctrine.orm,datetime" />
        </sensio-framework-extra:config>

To detect which converter is run on a parameter the following process is run:

* If an explicit converter choice was made with
  ``@ParamConverter(converter="name")`` the converter with the given name is
  chosen.

* Otherwise all registered parameter converters are iterated by priority. The
  ``supports()`` method is invoked to check if a param converter can convert
  the request into the required parameter. If it returns ``true`` the param
  converter is invoked.

Built-in Converters
-------------------

The bundle has two built-in converters, the Doctrine one and a DateTime
converter.

Doctrine Converter
~~~~~~~~~~~~~~~~~~

Converter Name: ``doctrine.orm``

The Doctrine Converter attempts to convert request attributes to Doctrine
entities fetched from the database. Several different approaches are possible:

1) Fetch Automatically
......................

If your route wildcards match properties on your entity, then
the converter will automatically fetch them::

    /**
     * Fetch via primary key because {id} is in the route.
     *
     * @Route("/blog/{id}")
     */
    public function showByPk(Post $post)
    {
    }

    /**
     * Perform a findOneBy() where the slug property matches {slug}.
     *
     * @Route("/blog/{slug}")
     */
    public function show(Post $post)
    {
    }

Automatic fetching works in these situations:

* If ``{id}`` is in your route, then this is used to fetch by
  primary key via the ``find()`` method.

* The converter will attempt to do a ``findOneBy()`` fetch by using
  *all* of the wildcards in your route that are actually properties
  on your entity (non-properties are ignored).

You can control this behavior by actually *adding* the ``@ParamConverter``
annotation and using the `@ParamConverter options`_.

2) Fetch via an Expression
..........................

If automatic fetching doesn't work, another great option is to use
an expression::

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

    /**
     * @Route("/blog/{post_id}")
     * @Entity("post", expr="repository.find(post_id)")
     */
    public function show(Post $post)
    {
    }

Use the special ``@Entity`` annotation with an ``expr`` option to
fetch the object by calling a method on your repository. The
``repository`` method will be your entity's Repository class and
any route wildcards - like ``{post_id}`` are available as variables.

.. tip::

    The ``@Entity`` annotation is a shortcut for using ``expr``
    and has all the same options as ``@ParamConverter``.

This can also be used to help resolve multiple arguments::

    /**
     * @Route("/blog/{id}/comments/{comment_id}")
     * @Entity("comment", expr="repository.find(comment_id)")
     */
    public function show(Post $post, Comment $comment)
    {
    }

In the example above, the ``$post`` parameter is handled automatically, but ``$comment``
is configured with the annotation since they cannot both follow the default convention.

.. _`@ParamConverter options`:

DoctrineConverter Options
.........................

A number of ``options`` are available on the ``@ParamConverter`` or
(``@Entity``) annotation to control behavior:

* ``id``: If an ``id`` option is configured and matches a route parameter, then the
  converter will find by the primary key::

    /**
     * @Route("/blog/{post_id}")
     * @ParamConverter("post", options={"id" = "post_id"})
     */
    public function showPost(Post $post)
    {
    }

* ``mapping``: Configures the properties and values to use with the ``findOneBy()``
  method: the key is the route placeholder name and the value is the Doctrine property
  name::

    /**
     * @Route("/blog/{date}/{slug}/comments/{comment_slug}")
     * @ParamConverter("post", options={"mapping": {"date": "date", "slug": "slug"}})
     * @ParamConverter("comment", options={"mapping": {"comment_slug": "slug"}})
     */
    public function showComment(Post $post, Comment $comment)
    {
    }

* ``exclude`` Configures the properties that should be used in the ``findOneBy()``
  method by *excluding* one or more properties so that not *all* are used::

    /**
     * @Route("/blog/{date}/{slug}")
     * @ParamConverter("post", options={"exclude": {"date"}})
     */
    public function show(Post $post, \DateTime $date)
    {
    }

* ``strip_null`` If true, then when ``findOneBy()`` is used, any values that are
  ``null`` will not be used for the query.

* ``entity_manager`` By default, the Doctrine converter uses the *default* entity
  manager, but you can configure this::

    /**
     * @Route("/blog/{id}")
     * @ParamConverter("post", options={"entity_manager" = "foo"})
     */
    public function show(Post $post)
    {
    }

* ``evict_cache`` If true, forces Doctrine to always fetch the entity from the database instead of cache.

DateTime Converter
~~~~~~~~~~~~~~~~~~

Converter Name: ``datetime``

The datetime converter converts any route or request attribute into a datetime
instance::

    /**
     * @Route("/blog/archive/{start}/{end}")
     */
    public function archive(\DateTime $start, \DateTime $end)
    {
    }

By default any date format that can be parsed by the ``DateTime`` constructor
is accepted. You can be stricter with input given through the options::

    /**
     * @Route("/blog/archive/{start}/{end}")
     * @ParamConverter("start", options={"format": "Y-m-d"})
     * @ParamConverter("end", options={"format": "Y-m-d"})
     */
    public function archive(\DateTime $start, \DateTime $end)
    {
    }

A date in a wrong format like ``2017-21-22`` will return a 404.

Creating a Converter
--------------------

All converters must implement the ``ParamConverterInterface``::

    namespace Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
    use Symfony\Component\HttpFoundation\Request;

    interface ParamConverterInterface
    {
        function apply(Request $request, ParamConverter $configuration);

        function supports(ParamConverter $configuration);
    }

The ``supports()`` method must return ``true`` when it is able to convert the
given configuration (a ``ParamConverter`` instance).

The ``ParamConverter`` instance has three pieces of information about the annotation:

* ``name``: The attribute name;
* ``class``: The attribute class name (can be any string representing a class
  name);
* ``options``: An array of options.

The ``apply()`` method is called whenever a configuration is supported. Based
on the request attributes, it should set an attribute named
``$configuration->getName()``, which stores an object of class
``$configuration->getClass()``.

If you're using service `auto-registration and autoconfiguration`_,
you're done! Your converter will automatically be used.
If not, you must add a tag to your service:

.. configuration-block::

    .. code-block:: yaml

        # app/config/config.yml
        services:
            my_converter:
                class:        MyBundle\Request\ParamConverter\MyConverter
                tags:
                    - { name: request.param_converter, priority: -2, converter: my_converter }

    .. code-block:: xml

        <service id="my_converter" class="MyBundle\Request\ParamConverter\MyConverter">
            <tag name="request.param_converter" priority="-2" converter="my_converter" />
        </service>

You can register a converter by priority, by name (attribute "converter"), or
both. If you don't specify a priority or a name, the converter will be added to
the converter stack with a priority of ``0``. To explicitly disable the
registration by priority you have to set ``priority="false"`` in your tag
definition.

.. tip::

   If you would like to inject services or additional arguments into a custom
   param converter, the priority shouldn't be higher than ``1``. Otherwise, the
   service wouldn't be loaded.

.. tip::

   Use the ``DoctrineParamConverter`` class as a template for your own converters.

.. _auto-registration and autoconfiguration: http://symfony.com/doc/current/service_container/3.3-di-changes.html
