<?php

namespace Statusboard\Table\Cell;

class ProjectIcon extends AbstractProjectCell
{
    protected $title = "Icon";

    public function test($value)
    {
        if (preg_match("/^(.+)(\.(jpg|png|gif)+)$/", $value) == false) {
            throw new \InvalidArgumentException("Icon must have extension .jpg, .png or .gif");
        }
        return $value;
    }


    public function parse($value)
    {
        $content = "<img src=\"{$value}\">";
        return parent::parse($content);
    }
}
