UPGRADE to 3.0
==============

* The automatic loading of fixtures in a directory (e.g.
    AppBundle\DataFixtures\ORM) was removed. Instead, register
    your fixture classes as services and tag them with `doctrine.fixture.orm`,
    like this:
```yaml
# src/AppBundle/Resources/config/dataFixture.yml
services:
  _defaults:
    tags: ['doctrine.fixture.orm']
    autowire: true # if you need dependency injection, see next bullet point

  AppBundle\DataFixtures\ORM\:
    resource: '../../DataFixtures/ORM/*'
```

  This will happen automatically if you're using the Symfony 3.3
    or higher **default service configuration** and your fixture classes
    extend the normal ``Doctrine\Bundle\FixturesBundle\Fixture`` class,
    or implement the new ``Doctrine\Bundle\FixturesBundle\ORMFixtureInterface``.

* The base ``Fixture`` class no longer implements ``ContainerAwareInterface``
    and so no longer have a ``$this->container`` property. You *can* manually
    implement this interface. Or, a better idea is to update your fixtures
    to use dependency injection:
    
```diff
class MyFixture extends Fixture
{
+     private $someService;

+     public function __construct(SomeService $someService)
+     {
+         $this->someService = $someService;
+     }

    public function load(ObjectManager $manager)
    {
-         $this->container->get('some_service')->someMethod();
+         $this->someService->someMethod();
    }
}
```

* The base ``Fixture`` class no longer implements ``DependentFixtureInterface``.
    If you want to have a ``getDependencies()`` method, be sure to implement
    this interface explicitly:
    
```diff
+ use Doctrine\Common\DataFixtures\DependentFixtureInterface;

- class MyFixture extends Fixture
+ class MyFixture extends Fixture implements DependentFixtureInterface
```
