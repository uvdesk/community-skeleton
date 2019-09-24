@Template
=========

As of version 4.0 of the bundle, only Twig is supported by the ``@Template``
annotation (and only when **not** used with the Symfony Templating component --
no ``templating`` entry set in the ``framework`` configuration settings).

Usage
-----

The ``@Template`` annotation associates a controller with a template name::

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

    /**
     * @Template("@SensioBlog/post/show.html.twig")
     */
    public function show($id)
    {
        // get the Post
        $post = ...;

        return array('post' => $post);
    }

When using the ``@Template`` annotation, the controller should return an
array of parameters to pass to the view instead of a ``Response`` object.

.. note::

    If you want to stream your template, you can make it with the following configuration::

        /**
         * @Template(isStreamable=true)
         */
        public function show($id)
        {
            // ...
        }


.. tip::
   If the action returns a ``Response`` object, the ``@Template`` 
   annotation is simply ignored.

If the template is named after the controller and action names, which is the
case for the above example, you can even omit the annotation value::

    /**
     * @Template
     */
    public function show($id)
    {
        // get the Post
        $post = ...;

        return array('post' => $post);
    }

.. tip::
   Sub-namespaces are converted into underscores. 
   The ``Sensio\BlogBundle\Controller\UserProfileController::showDetails()`` action
   will resolve to ``@SensioBlog/user_profile/show_details.html.twig``

And if the only parameters to pass to the template are method arguments, you
can use the ``vars`` attribute instead of returning an array. This is very
useful in combination with the ``@ParamConverter`` :doc:`annotation
<converters>`::

    /**
     * @ParamConverter("post", class="SensioBlogBundle:Post")
     * @Template("@SensioBlog/post/show.html.twig", vars={"post"})
     */
    public function show(Post $post)
    {
    }

which, thanks to conventions, is equivalent to the following configuration::

    /**
     * @Template(vars={"post"})
     */
    public function show(Post $post)
    {
    }

You can make it even more concise as all method arguments are automatically
passed to the template if the method returns ``null`` and no ``vars``
attribute is defined::

    /**
     * @Template
     */
    public function show(Post $post)
    {
    }
