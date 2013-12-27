<?php
/**
 * Created by PhpStorm.
 * User: humsie
 * Date: 24-12-13
 * Time: 20:30
 */

namespace Statusboard\Graph;


abstract class AbstractDatapoint implements DatapointInterface
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
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException("value must be a numeric value");
        }
        $this->value = (float)$value;
    }

    public function getValue()
    {
        return $this->value;
    }

    final public function jsonSerialize()
    {
        $tmp = new \stdClass();

        $tmp->title = $this->getTitle();
        $tmp->value = $this->getValue();

        return $tmp;

    }
}
