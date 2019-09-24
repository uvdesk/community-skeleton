<?php

namespace Egulias\EmailValidator\Warning;

class QuotedPart extends Warning
{
    const CODE = 36;

    public function __construct($prevToken, $postToken)
    {
        $this->message = "Deprecated Quoted String found between $prevToken and $postToken";
    }
}
