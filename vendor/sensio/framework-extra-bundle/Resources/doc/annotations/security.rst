@Security & @IsGranted
======================

Usage
-----

The ``@Security`` and ``@IsGranted`` annotations restrict access on controllers::

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

    class PostController extends Controller
    {
        /**
         * @IsGranted("ROLE_ADMIN")
         *
         * or use @Security for more flexibility:
         *
         * @Security("is_granted('ROLE_ADMIN') and is_granted('ROLE_FRIENDLY_USER')")
         */
        public function index()
        {
            // ...
        }
    }

@IsGranted
----------

The ``@IsGranted()`` annotation is the simplest way to restrict access.
Use it to restrict by roles, or use custom voters to restrict access based
on variables passed to the controller::

    /**
     * @Route("/posts/{id}")
     *
     * @IsGranted({"ROLE_ADMIN", "ROLE_SYSTEM"})
     * @IsGranted("POST_SHOW", subject="post")
     */
    public function show(Post $post)
    {
    }

Each ``IsGranted()`` must grant access for the user to have access to the controller.

.. tip::

    The ``@IsGranted("POST_SHOW", subject="post")`` is an example of using
    a custom security voter. For more details, see `the Security Voters page`_.

You can also control the message and status code::

    /**
     * Will throw a normal AccessDeniedException:
     *
     * @IsGranted("ROLE_ADMIN", message="No access! Get out!")
     *
     * Will throw an HttpException with a 404 status code:
     *
     * @IsGranted("ROLE_ADMIN", statusCode=404, message="Post not found")
     */
    public function show(Post $post)
    {
    }

@Security
---------

The ``@Security`` annotation is more flexible than ``@IsGranted``: it
allows you to pass an *expression* that can contains custom logic::

    /**
     * @Security("is_granted('ROLE_ADMIN') and is_granted('POST_SHOW', post)")
     */
    public function show(Post $post)
    {
        // ...
    }


The expression can use all functions that you can use in the ``access_control``
section of the security bundle configuration, with the addition of the
``is_granted()`` function.

The expression has access to the following variables:

* ``token``: The current security token;
* ``user``: The current user object;
* ``request``: The request instance;
* ``roles``: The user roles;
* and all request attributes.

You can throw an ``Symfony\Component\HttpKernel\Exception\HttpException``
exception instead of
``Symfony\Component\Security\Core\Exception\AccessDeniedException`` using the
``statusCode`` option::

    /**
     * @Security("is_granted('POST_SHOW', post)", statusCode=404)
     */
    public function show(Post $post)
    {
    }

The ``message`` option allows you to customize the exception message::

    /**
     * @Security("is_granted('POST_SHOW', post)", statusCode=404, message="Resource not found.")
     */
    public function show(Post $post)
    {
    }

.. tip::

    You can also add ``@IsGranted`` or  ``@Security`` annotations on a controller
    class to prevent access to *all* actions in the class.

.. _`the Security Voters page`: http://symfony.com/doc/current/cookbook/security/voters_data_permission.html
