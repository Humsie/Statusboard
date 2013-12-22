<?php

namespace Statusboard\Graph;

use Statusboard\Exceptions\IdentifierAlreadyExistsException;
use Statusboard\Exceptions\IdentifierNotFoundException;

class Datasequence
{
    const SORT_OFF = 0;
    const SORT_ASC = SORT_ASC;
    const SORT_DESC = SORT_DESC;

    protected $title = "";
    protected $color = "";
    protected $datapoints = array();
    protected $sortmode = 0;

    public function __construct($strTitle)
    {
        $this->setTitle($strTitle);
        return $this;
    }

    public function setSort($mode = 0)
    {
        if (in_array($mode, array(static::SORT_OFF, static::SORT_ASC, static::SORT_DESC, static::SORT_NATURAL))) {
            $this->sortmode = $mode;
        }
    }

    public function setColor($strColor)
    {
        if (in_array(
            $strColor,
            array("yellow", "green", "red", "purple", "blue", "mediumGray", "pink", "aqua", "orange", "lightGray")
        )
        ) {
            $this->color = (string)$strColor;
        } else {
            $this->color = "";
        }
        return $this;
    }

    public function setTitle($strTitle)
    {
        $this->title = (string)$strTitle;
        return $this;
    }


    public function getSort()
    {
        return $this->sortmode;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function newDatapoint($strTitle, $fltValue)
    {
        $dp = new Datapoint();
        $dp->setTitle($strTitle);
        $dp->setValue($fltValue);
        $this->addDatapoint($dp);
        return $this;
    }

    public function addDatapoint(Datapoint $datapoint)
    {
        if (array_key_exists($datapoint->getTitle(), $this->datapoints)) {
            throw new IdentifierAlreadyExistsException("Datapoint {$datapoint->getTitle()} already present");
        }
        $this->datapoints[$datapoint->getTitle()] = $datapoint;
    }

    public function datapoint($identifier)
    {
        if (!is_string($identifier) && !is_int($identifier)) {
            throw new \InvalidArgumentException("Identifier should be a string or an integer");
        }
        if (is_int($identifier) && $identifier >= 0 && $identifier < count($this->datasequences)) {
            $identifier = array_keys($this->datasequences);
        }

        if (array_key_exists($identifier, $this->datapoints)) {
            return $this->datapoints[$identifier];
        }
        throw new IdentifierNotFoundException("datapoint {$identifier} does not exist");
    }

    public function __toJson()
    {
        $tmp = new \stdClass();
        $tmp->title = $this->getTitle();
        if ($this->getColor() != "") {
            $tmp->color = $this->getColor();
        }
        $tmp->datapoints = array();
        $datapoints = $this->datapoints;
        if ($this->getSort() !== static::SORT_OFF) {
            ksort($datapoints, $this->getSort());
        }

        foreach ($datapoints as $datapoint) {
            array_push($tmp->datapoints, $datapoint->__toJson());
        }
        return $tmp;
    }
}
