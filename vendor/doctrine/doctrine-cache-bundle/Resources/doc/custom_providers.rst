Custom Providers
================

You can also register your own custom cache drivers:

.. configuration-block::

    .. code-block:: yaml

        # app/config/services.yml
        services:
            my_custom_provider_service:
                class: "MyCustomType"
                # ...

        # app/config/config.yml
        doctrine_cache:
            custom_providers:
                my_custom_type:
                    prototype:  "my_custom_provider_service"
                    definition_class: "MyCustomTypeDefinition" # optional configuration

            providers:
                my_custom_type_provider:
                    my_custom_type:
                        config_foo: "foo"
                        config_bar: "bar"

    .. code-block:: xml

        <!-- app/config/config.xml -->
        <?xml version="1.0" encoding="UTF-8" ?>
        <dic:container xmlns="http://doctrine-project.org/schemas/symfony-dic/cache"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xmlns:srv="http://symfony.com/schema/dic/services"
            xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd
                http://doctrine-project.org/schemas/symfony-dic/cache http://doctrine-project.org/schemas/symfony-dic/cache/doctrine_cache-1.0.xsd">

        <srv:container>
            <srv:services>
                <srv:service id="my_custom_provider_service" class="MyCustomType">
                    <!-- ... -->
                </srv:service>
             </srv:services>

            <doctrine-cache>
                <!-- register your custom cache provider -->
                <custom-provider type="my_custom_type">
                    <prototype>my_custom_provider_service</prototype>
                    <definition-class>MyCustomTypeDefinition</definition-class> <!-- optional configuration -->
                </custom-provider>

                 <provider name="my_custom_type_provider">
                    <my_custom_type>
                         <config-foo>foo</config-foo>
                         <config-bar>bar</config-bar>
                     </my_custom_type>
                 </provider>
            </doctrine-cache>
        </srv:container>

.. note::

    Definition class is a optional configuration that will parse option arguments
    given to your custom cache driver. See `CacheDefinition code`_.

.. _`CacheDefinition code`: https://github.com/doctrine/DoctrineCacheBundle/blob/master/DependencyInjection/Definition/CacheDefinition.php
