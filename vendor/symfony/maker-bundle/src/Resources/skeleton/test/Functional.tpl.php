<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

<?php if($panther_is_available): ?>
use Symfony\Component\Panther\PantherTestCase;
<?php else: ?>
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
<?php endif ?>

class <?= $class_name ?> extends <?= $panther_is_available ? 'PantherTestCase' : 'WebTestCase' ?><?= "\n" ?>
{
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

<?php if($web_assertions_are_available): ?>
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World');
<?php else: ?>
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Hello World', $crawler->filter('h1')->text());
<?php endif ?>
    }
}
