<?php

namespace Statusboard\Table\Row;

interface RowInterface extends \Iterator
{

    public function parseRow();

    public function parseHeader();

    public function parseCSS();

    public function getId();

    public function setStructure($array);

    public function addCellToStructure(\Statusboard\Table\Cell\CellInterface $cell, $indentifier = null);
}
