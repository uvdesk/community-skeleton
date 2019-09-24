# Creating custom subscriber

Lets say we want to paginate a directory content, might be quite interesting.
And when we have such a handy **Finder** component in symfony, its easily achievable.

## Prepare environment

I will assume we you just installed [symfony-standard](https://github.com/symfony/symfony-standard)
edition and you install [KnpPaginatorBundle](https://github.com/knplabs/KnpPaginatorBundle).
Follow the installation guide on these repositories, its very easy to setup.

## Create subscriber

Next, lets extend our **AcmeDemoBundle** which comes together with **symfony-standard** edition.
Create file **../symfony-standard/src/Acme/DemoBundle/Subscriber/PaginateDirectorySubscriber.php**

``` php
<?php

// file: ../symfony-standard/src/Acme/DemoBundle/Subscriber/PaginateDirectorySubscriber.php
// requires // Symfony\Component\Finder\Finder

namespace Acme\DemoBundle\Subscriber;

use Symfony\Component\Finder\Finder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Component\Pager\Event\ItemsEvent;

class PaginateDirectorySubscriber implements EventSubscriberInterface
{
    public function items(ItemsEvent $event)
    {
        if (is_string($event->target) && is_dir($event->target)) {
            $finder = new Finder;
            $finder
                ->files()
                ->depth('< 4') // 3 levels
                ->in($event->target)
            ;
            $iter = $finder->getIterator();
            $files = iterator_to_array($iter);
            $event->count = count($files);
            $event->items = array_slice(
                $files,
                $event->getOffset(),
                $event->getLimit()
            );
            $event->stopPropagation();
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            'knp_pager.items' => array('items', 1/*increased priority to override any internal*/)
        );
    }
}
```

Class above is the simple event subscriber, which listens to **knp_pager.items** event.
Creates a finder and looks in this directory for files. To be more specific it will look
for the **files** in the directory being paginated, max in 3 level depth.

## Register subscriber as service

Next we need to tell **knp_paginator** about our new fancy subscriber which we intend
to use in pagination. It is also very simple, create additional service config file:
**../symfony-standard/src/Acme/DemoBundle/Resources/config/paginate.xml**

``` html
<?xml version="1.0" ?>

<!-- file: ../symfony-standard/src/Acme/DemoBundle/Resources/config/paginate.xml -->

<container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">

    <services>
        <service id="acme.directory.subscriber" class="Acme\DemoBundle\Subscriber\PaginateDirectorySubscriber">
            <tag name="knp_paginator.subscriber" />
        </service>
    </services>
</container>
```

## Load configuration into container

Now to finish this configuration we need to load it from our dependency injection extension.
Modify file: **../symfony-standard/src/Acme/DemoBundle/DependencyInjection/config/AcmeDemoExtension.php**

``` php
<?php
// modify load method, to look like:
public function load(array $configs, ContainerBuilder $container)
{
    $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.xml');
    // loading our pagination services
    $loader->load('paginate.xml');
}
```

## Controller action

Finally, we are done with configuration, now lets create actual controller action.
Modify controller: **../symfony-standard/src/Acme/DemoBundle/Controller/DemoController.php**
And add the following action, which paginates the previous directory

``` php
<?php
/**
 * @Route("/test", name="_demo_test")
 * @Template()
 */
public function testAction()
{
    $paginator = $this->get('knp_paginator');
    $files = $paginator->paginate(
        __DIR__.'/../',
        $this->get('request')->query->getInt('page', 1),
        10
    );
    return compact('files');
}
```

## Template

And the last thing is the template, create: **../symfony-standard/src/Acme/DemoBundle/Resources/views/Demo/test.html.twig**

``` html
{% extends "AcmeDemoBundle::layout.html.twig" %}

{% block title "Symfony - Demos" %}

{% block content_header '' %}

{% block content %}
    <h1>Available demos</h1>
    <ul id="demo-list">
        <li><a href="{{ path('_demo_hello', {'name': 'World'}) }}">Hello World</a></li>
        <li><a href="{{ path('_demo_secured_hello', {'name': 'World'}) }}">Access the secured area</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ path('_demo_login') }}">Go to the login page</a></li>
        {# <li><a href="{{ path('_demo_contact') }}">Send a Message</a></li> #}
    </ul>

    <table>
    <tr>
    {# sorting of properties based on query components #}
        <th>base name</th>
        <th>path</th>
    </tr>

    {# table body #}
    {% for file in files %}
    <tr {% if loop.index is odd %}class="color"{% endif %}>
        <td>{{ file.getBaseName() }}</td>
        <td>{{ file.getPath() }}</td>
    </tr>
    {% endfor %}
    </table>
    {# display navigation #}
    <div id="navigation">
        {{ knp_pagination_render(files) }}
    </div>
{% endblock %}
```

Do not forget to reload the cache: **./app/console cache:clear -e dev**
You should find some files paginated if you open
the url: **http://baseurl/app_dev.php/demo/test**
