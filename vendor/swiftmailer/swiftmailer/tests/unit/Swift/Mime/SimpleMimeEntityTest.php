<?php


class Swift_Mime_SimpleMimeEntityTest extends Swift_Mime_AbstractMimeEntityTest
{
    protected function createEntity($headerFactory, $encoder, $cache)
    {
        $idGenerator = new Swift_Mime_IdGenerator('example.com');

        return new Swift_Mime_SimpleMimeEntity($headerFactory, $encoder, $cache, $idGenerator);
    }
}
