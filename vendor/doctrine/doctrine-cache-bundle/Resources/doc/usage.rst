Usage
=====

First, configure your cache providers under the ``doctrine_cache`` configuration
option. Example:

.. configuration-block::

    .. code-block:: yaml

        # app/config/config.yml
        doctrine_cache:
            providers:
                my_apc_metadata_cache:
                    type: apc
                    namespace: metadata_cache_ns
                my_apc_query_cache:
                    namespace: query_cache_ns
                    apc: ~

    .. code-block:: xml

        <!-- app/config/config.xml -->
        <?xml version="1.0" encoding="UTF-8" ?>
        <container xmlns="http://symfony.com/schema/dic/services"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xmlns:doctrine-cache="http://doctrine-project.org/schemas/symfony-dic/cache"
            xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd
                http://doctrine-project.org/schemas/symfony-dic/cache http://doctrine-project.org/schemas/symfony-dic/cache/doctrine_cache-1.0.xsd">

            <doctrine-cache:doctrine-cache>
                 <doctrine-cache:provider name="my_apc_metadata_cache">
                    <doctrine-cache:type>apc</doctrine-cache:type>
                    <doctrine-cache:namespace>metadata_cache_ns</doctrine-cache:namespace>
                 </doctrine-cache:provider>
                <doctrine-cache:provider name="my_apc_query_cache" namespace="query_cache_ns">
                    <doctrine-cache:apc/>
                <doctrine-cache:provider>
            </doctrine-cache:doctrine-cache>
        </container>

Then, use the newly created ``doctrine_cache.providers.{provider_name}`` container
services anywhere in your application::

    $metadataCache = $this->container->get('doctrine_cache.providers.my_apc_metadata_cache');
    $queryCache = $this->container->get('doctrine_cache.providers.my_apc_query_cache');

Service Aliases
---------------

In order to make your code more concise, you can define aliases for these services
thanks to the ``aliases`` configuration option. Example:

.. configuration-block::

    .. code-block:: yaml

        # app/config/config.yml
        doctrine_cache:
            aliases:
                apc_cache: my_apc_cache

            providers:
                my_apc_cache:
                    type: apc
                    namespace: my_apc_cache_ns
                    aliases:
                        - apc_cache

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
                <alias key="apc_cache">my_apc_cache</alias>

                <provider name="my_apc_cache">
                    <type>apc</type>
                    <namespace>my_apc_cache_ns</namespace>
                    <alias>apc_cache</alias>
                </provider>
            </doctrine-cache>
        </srv:container>

Now you can use the short ``apc_cache`` alias to get the provider called
``my_apc_cache``, instead of using ``doctrine_cache.providers.my_apc_cache``::

    $apcCache = $this->container->get('apc_cache');
