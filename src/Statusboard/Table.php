<?php

namespace Statusboard;

class Table
{
    protected $rows;

    protected $includeHeaders;

    public function __construct(Table\Row\RowInterface $rowTemplate)
    {
        $this->rows = $rowTemplate;
        $this->includeHeaders = true;
    }

    public function addRow($identifier)
    {
        return $this->rows->addRow($identifier);
    }

    public function row($identifier)
    {
        return $this->rows->selectByIdentifier($identifier);
    }

    public function showHeaders()
    {
        $this->includeHeaders = true;
    }
    public function hideHeaders()
    {
        $this->includeHeaders = false;
    }

    public function getId()
    {
        return (string)$this->rows->getId();
    }

    public function getCSS()
    {
        return "";
    }

    public function getOutput()
    {

        $output = $this->getCSS();
        $output .= $this->rows->parseCSS();

        if (trim($output) != "") {
            $output = "<style type=\"text/css\">{$output}</style>";
        }


        $output .= "<table id=\"{$this->getId()}\">";

        if ($this->includeHeaders) {
            $output .= $this->rows->parseHeader();
        }

        foreach ($this->rows as $row) {
            $output .= $this->rows->parseRow();
        }
        $output .= "</table>";

        return $output;
    }
}
