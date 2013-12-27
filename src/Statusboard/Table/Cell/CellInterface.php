<?php

namespace Statusboard\Table\Cell;

interface CellInterface
{

    public function getClass();

    public function test($value);

    public function parse($value);

    public function parseHeader();

    public function parseCSS();

    public function getDefaultValue();
}
