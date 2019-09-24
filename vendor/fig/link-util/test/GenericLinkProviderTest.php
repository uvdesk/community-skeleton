<?php


namespace Fig\Link\Tests;

use Fig\Link\GenericLinkProvider;
use Fig\Link\Link;

class GenericLinkProviderTest extends \PHPUnit_Framework_TestCase
{

    public function test_can_add_links_by_method()
    {
        $link = (new Link())
            ->withHref('http://www.google.com')
            ->withRel('next')
            ->withAttribute('me', 'you')
        ;

        $provider = (new GenericLinkProvider())
            ->withLink($link);

        $this->assertContains($link, $provider->getLinks());
    }


    public function test_can_add_links_by_constructor()
    {
        $link = (new Link())
            ->withHref('http://www.google.com')
            ->withRel('next')
            ->withAttribute('me', 'you')
        ;

        $provider = (new GenericLinkProvider())
            ->withLink($link);

        $this->assertContains($link, $provider->getLinks());
    }

    public function test_can_get_links_by_rel()
    {
        $link1 = (new Link())
            ->withHref('http://www.google.com')
            ->withRel('next')
            ->withAttribute('me', 'you')
        ;
        $link2 = (new Link())
            ->withHref('http://www.php-fig.org/')
            ->withRel('home')
            ->withAttribute('me', 'you')
        ;

        $provider = (new GenericLinkProvider())
            ->withLink($link1)
            ->withLink($link2);

        $links = $provider->getLinksByRel('home');
        $this->assertContains($link2, $links);
        $this->assertFalse(in_array($link1, $links));
    }

    public function test_can_remove_links()
    {
        $link = (new Link())
            ->withHref('http://www.google.com')
            ->withRel('next')
            ->withAttribute('me', 'you')
        ;

        $provider = (new GenericLinkProvider())
            ->withLink($link)
            ->withoutLink($link);

        $this->assertFalse(in_array($link, $provider->getLinks()));
    }
}
