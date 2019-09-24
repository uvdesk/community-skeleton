Symfony ACL Cache
=================

.. configuration-block::

    .. code-block:: yaml

        # app/config/config.yml
        doctrine_cache:
            acl_cache:
                id: 'doctrine_cache.providers.acl_apc_provider'
            providers:
                acl_apc_provider:
                    type: 'apc'

    .. code-block:: xml

        <!-- app/config/config.xml -->
        <?xml version="1.0" encoding="UTF-8" ?>
        <dic:container xmlns="http://doctrine-project.org/schemas/symfony-dic/cache"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xmlns:srv="http://symfony.com/schema/dic/services"
            xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd
                http://doctrine-project.org/schemas/symfony-dic/cache http://doctrine-project.org/schemas/symfony-dic/cache/doctrine_cache-1.0.xsd">

        <srv:container>
            <doctrine-cache>
                <acl-cache id="doctrine_cache.providers.acl_apc_provider"/>

                <provider name="acl_apc_provider" type="apc"/>
            </doctrine-cache>
        </srv:container>

Check the following sample::

    /** @var $aclCache Symfony\Component\Security\Acl\Model\AclCacheInterface */
    $aclCache = $this->container->get('security.acl.cache');
