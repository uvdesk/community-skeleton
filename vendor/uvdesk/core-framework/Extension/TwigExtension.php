<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Extension;

class TwigExtension extends \Twig_Extension
{
    /**
     * Here we declare our custom filter with their respective function
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('addslashes', array($this, 'addslashes')),
        );
    }

    /**
     * add slash on string
     */
    public function addslashes($string)
    {
        return addslashes($string);
    }

    /**
     * utf8 decode string
     */
    public function utf8_decode($string) {
        return utf8_decode($string);
    }

    /**
     * json decode string
     */
    public function json_decode($string) {
        return json_decode($string);
    }

    /**
     * urldecode string
     */
    public function urldecode($string) {
        return urldecode($string);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twig_extension';
    }
}

?>
