<?php

namespace opensourceame\Config\Output;

class Output
{

    protected        $parent            = null;

    public function __construct($parent)
    {
        $this->parent = $parent;
    }

    public function output()
    {

    }
}
