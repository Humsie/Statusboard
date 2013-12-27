<?php

namespace Statusboard\Table\Row;

class Projects extends AbstractRow implements \Iterator, RowInterface
{
    public function __construct()
    {
        parent::__construct();

        $this->setStructure(
            array(
                "icon"      => new \Statusboard\Table\Cell\ProjectIcon(),
                "name"      => new \Statusboard\Table\Cell\ProjectName(),
                "version"   => new \Statusboard\Table\Cell\ProjectVersion(),
                "persons"   => new \Statusboard\Table\Cell\ProjectPersons(),
                "bars"      => new \Statusboard\Table\Cell\ProjectBars()
            )
        );

    }

    public function addPerson($person)
    {
        array_push($this->array[$this->position]["persons"], $this->cells["persons"]->test($person));
        return $this;
    }

    public function getId()
    {
        return "projects";
    }
}
