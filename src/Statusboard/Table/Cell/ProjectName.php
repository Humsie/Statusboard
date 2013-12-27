<?php

namespace Statusboard\Table\Cell;

class ProjectName extends AbstractProjectCell
{
    protected $title = "Project";

    public function parseCSS()
    {
        return "
        th.projectName {
            width: auto;
        }
        ";
    }
}
