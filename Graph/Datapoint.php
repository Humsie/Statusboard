<?php

namespace Humsie\Statusboard\Graph;

class Datapoint
{
    protected $title = "";
    protected $value = 0.0;


    public function setTitle($title)
    {
        $this->title = (string)$title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setValue($value)
    {
        $this->value = (float)$value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toJson()
    {
        $tmp = new \stdClass();

        $tmp->title = $this->getTitle();
        $tmp->value = $this->getValue();

        return $tmp;

    }
}
