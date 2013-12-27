<?php

namespace Statusboard\Table\Cell;

class ProjectPersons extends AbstractProjectCell
{
    protected $title = "Team";

    public function parseCSS()
    {
        return "
        th.projectPersons {
            width: 100px;
        }
        ";
    }

    public function parse($value)
    {
        $content = "";
        if (is_array($value)) {
            foreach ($value as $path) {
                $content .= "<img class=\"person\" src=\"{$path}\">";
            }
        }
        return parent::parse($content);
    }

    public function getDefaultValue()
    {
        return array();
    }
}
