<?php

namespace Statusboard\Table\Row;

class AbstractRow implements \Iterator, RowInterface
{
    protected $position = 0;

    protected $cells = array();

    protected $array = array();

    protected $arrayIdentifiers = array();

    public function __construct()
    {
        $this->position = 0;
        $this->cells = array();
        $this->array = array();
        return $this;
    }

    public function addRow($identifier)
    {
        $this->arrayIdentifiers[$identifier] = count($this->array);

        $defaults = array();
        foreach ($this->cells as $cellid => $cell) {
            $defaults[$cellid] = $cell->getDefaultValue();
        }

        array_push($this->array, $defaults);
        $this->selectByIdentifier($identifier);
        return $this;
    }

    public function selectByIdentifier($identifier)
    {
        if (!array_key_exists($identifier, $this->arrayIdentifiers)) {
            throw new \Statusboard\Exceptions\IdentifierNotFoundException("Identifier {$identifier} not found");
        }
        $this->position = $this->arrayIdentifiers[$identifier];
        return $this;
    }

    public function getId()
    {
        return "";
    }

    public function __call($name, $arguments)
    {
        $action = substr($name, 0, 3);
        if ($action == "set" || $action == "get" || $action == "add") {
            $param = strtolower(substr($name, 3, 1)) . substr($name, 4);
            if (array_key_exists($param, $this->cells)) {
                if ($action == "set") {
                    $this->array[$this->position][$param] = $this->cells[$param]->test($arguments[0]);
                    return $this;
                }
                if ($action == "get") {
                    return (
                        isset($this->array[$this->position][$param])
                            ? $this->array[$this->position][$param]
                            : null
                    );
                }
                if ($action == "add") {
                    array_push($this->array[$this->position][$param], $this->cells[$param]->test($arguments[0]));
                    return $this;
                }
            }
        }

        throw new \BadMethodCallException("method {$name} doesnt exists");
    }


    public function setStructure($array)
    {
        $this->cells = array();

        foreach ($array as $identifier => $cell) {
            $this->addCellToStructure($cell, $identifier);
        }

        return $this;
    }

    public function addCellToStructure(\Statusboard\Table\Cell\CellInterface $cell, $indentifier = null)
    {
        if (is_null($indentifier)) {
            array_push($this->cells, $cell);
        } else {
            $this->cells[$indentifier] = $cell;
        }
        return $this;
    }

    public function parseCSS()
    {
        $content = "";
        foreach ($this->cells as $i => $cell) {
            $content .= $cell->parseCss();
        }
        return $content;
    }

    public function parseHeader()
    {
        $content = "<tr>";
        foreach ($this->cells as $i => $cell) {
            $content .= $cell->parseHeader();
        }
        $content .="</tr>";
        return $content;
    }

    public function parseRow()
    {
        $content = "<tr>";

        foreach ($this->cells as $i => $cell) {
            $content .= $cell->parse(
                isset($this->array[$this->position][$i])
                ? $this->array[$this->position][$i]
                : $cell->getDefaultValue()
            );
        }
        $content .= "</tr>";
        return $content;
    }

    /** Implementation of iteration **/
    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->array[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->array[$this->position]);
    }
}
