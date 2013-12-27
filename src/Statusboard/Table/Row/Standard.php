<?php

namespace Statusboard\Table\Row;

class Standard extends AbstractRow implements \Iterator, RowInterface
{
    protected $id;

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
