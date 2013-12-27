<?php

namespace Statusboard\Table\Cell;

class Standard implements CellInterface
{

    protected $class = "";
    protected $title = "";


    public function getClass()
    {
        return $this->class;
    }

    public function test($value)
    {
        return $value;
    }

    public function getDefaultValue()
    {
        return "";
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function parse($value)
    {
        return "<td class=\"{$this->getClass()}\">{$value}</td>";
    }

    public function parseCSS()
    {
        return "";
    }

    public function parseHeader()
    {
        return "<th class=\"{$this->getClass()}\">{$this->getTitle()}</th>";
    }
}
