<?php

namespace Statusboard\Table\Cell;

class ProjectBars extends AbstractProjectCell
{

    protected $title = "Activity?";

    public function __construct()
    {
        $return = parent::__construct();

        $this->class = "projectsBars";

        return $return;
    }

    public function parseCSS()
    {
        return "

            th.projectsBars {
                width: 104px;
                max-width: 104px;
                min-width: 104px;
            }
            td.projectsBars {
                width: 124px;
                max-width: 124px;
                min-width: 124px;
            }

            div.value9 {
                background-color: #70FF70;
            }

            div.value10 {
                background-color: #9AFF9A;
            }
        ";
    }

    public function test($value)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException("Bars Value must be numeric");
        }
        if (0 > $value || 10 < $value) {
            throw new \InvalidArgumentException("Bars value must be between 0 and 10");
        }
        return $value;
    }

    public function parse($value)
    {

        $content = "";
        for ($i = 1; $i <= 10; $i++) {
            if ((int)$value >= $i) {
                $content .= "<div class=\"barSegment value{$i}\"></div>";
            }
        }
        return parent::parse($content);
    }

    public function getDefaultValue()
    {
        return 0;
    }
}
