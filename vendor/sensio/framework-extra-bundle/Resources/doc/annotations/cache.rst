@Cache
======

The ``@Cache`` annotation makes it easy to define HTTP caching headers for
expiration and validation.

HTTP Expiration Strategies
--------------------------

The ``@Cache`` annotation makes it easy to define HTTP caching::

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

    /**
     * @Cache(expires="tomorrow", public=true)
     */
    public function index()
    {
    }

You can also use the annotation on a class to define caching for all actions
of a controller::

    /**
     * @Cache(expires="tomorrow", public=true)
     */
    class BlogController extends Controller
    {
    }

When there is a conflict between the class configuration and the method
configuration, the latter overrides the former::

    /**
     * @Cache(expires="tomorrow")
     */
    class BlogController extends Controller
    {
        /**
         * @Cache(expires="+2 days")
         */
        public function index()
        {
        }
    }

.. note::

   The ``expires`` attribute takes any valid date understood by the PHP
   ``strtotime()`` function.

HTTP Validation Strategies
--------------------------

The ``lastModified`` and ``Etag`` attributes manage the HTTP validation cache
headers. ``lastModified`` adds a ``Last-Modified`` header to Responses and
``Etag`` adds an ``Etag`` header.

Both automatically trigger the logic to return a 304 response when the
response is not modified (in this case, the controller is **not** called)::

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

    /**
     * @Cache(lastModified="post.getUpdatedAt()", Etag="'Post' ~ post.getId() ~ post.getUpdatedAt().getTimestamp()")
     */
    public function index(Post $post)
    {
        // your code
        // won't be called in case of a 304
    }

It's roughly doing the same as the following code::

    public function my(Request $request, Post $post)
    {
        $response = new Response();
        $response->setLastModified($post->getUpdatedAt());
        if ($response->isNotModified($request)) {
            return $response;
        }

        // your code
    }

.. note::

    The Etag HTTP header value is the result of the expression hashed with the
    ``sha256`` algorithm.

Attributes
----------

Here is a list of accepted attributes and their HTTP header equivalent:

======================================================================= ===================================================================
Annotation                                                              Response Method
======================================================================= ===================================================================
``@Cache(expires="tomorrow")``                                          ``$response->setExpires()``
``@Cache(smaxage="15")``                                                ``$response->setSharedMaxAge()``
``@Cache(maxage="15")``                                                 ``$response->setMaxAge()``
``@Cache(maxstale="15")``                                               ``$response->headers->addCacheControlDirective('max-stale', 15)``
``@Cache(vary={"Cookie"})``                                             ``$response->setVary()``
``@Cache(public=true)``                                                 ``$response->setPublic()``
``@Cache(lastModified="post.getUpdatedAt()")``                          ``$response->setLastModified()``
``@Cache(Etag="post.getId() ~ post.getUpdatedAt().getTimestamp()")``    ``$response->setEtag()``
``@Cache(mustRevalidate=true)``                                         ``$response->headers->addCacheControlDirective('must-revalidate')``
======================================================================= ===================================================================

.. note::

    smaxage, maxage and maxstale attributes can also get a string with relative time format (1 day, 2 weeks, ...).
