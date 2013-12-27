<?php

namespace Statusboard\Table\Cell;

abstract class AbstractProjectCell extends Standard implements CellInterface
{
    protected $class = "";

    public function __construct()
    {
        $this->setClassFromClass();
    }

    protected function setClassFromClass()
    {
        $this->class = str_replace(__NAMESPACE__ . "\\", "", get_class($this));

        $this->class = strtolower(substr($this->class, 0, 1)) . substr($this->class, 1);
    }

    public function getClass()
    {
        return $this->class;
    }
}
