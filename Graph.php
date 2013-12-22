<?php
/**
 * Graph Panel for Panic Statusboard
 *
 * @author  Humsie <github@tha-humise.com>
 */
namespace Humsie\Statusboard;

use Humsie\Statusboard\Graph\Axis;
use Humsie\Statusboard\Exceptions\IdentifierNotFoundException;
use Humsie\Statusboard\Exceptions\IdentifierAlreadyExistsException;

/**
 * Class Graph
 *
 * @package Humsie\Statusboard
 */
class Graph extends Panel
{
    protected $title = "";
    protected $refresh = 120;
    protected $showTotals = false;
    protected $type = "bar";
    protected $datasequences = array();

    protected $xaxis = null;
    protected $yaxis = null;

    public function __construct()
    {
        $this->xaxis = new Axis(Axis::AXIS_X);
        $this->yaxis = new Axis(Axis::AXIS_Y);
    }

    /**
     *
     * This will add a new datasequence to the graph
     * with an optional (short) identifier.
     *
     * @param string|Datasequence $datasequence A datasequence object or
     * a string to be used as title and identifier
     * @param null|string $identifier An custom identifier, is null title is used
     * @param bool $after add datasequence after datasequence with identifier
     * @throws Exceptions\IdentifierAlreadyExistsException
     * @throws \InvalidArgumentException
     * @throws Exceptions\IdentifierNotFoundException
     * @return datasequence
     */
    public function addDatasequence($datasequence, $identifier = null, $after = false)
    {

        if ($datasequence instanceof Graph\Datasequence) {
            $title = $datasequence->getTitle();
        } elseif (is_string($datasequence)) {
            $title = $datasequence;
            $datasequence = new Graph\Datasequence($title);
        } else {
            throw new \InvalidArgumentException("datasequence not an string or instance of Graph\\Datasequence");
        }

        if (is_null($identifier)) {
            $identifier = $title;
        }

        if (array_key_exists($identifier, $this->datasequences)) {
            throw new IdentifierAlreadyExistsException("Datasequence {$identifier} already exist");
        }

        if ($after !== false) {
            if (is_string($after)) {
                if (array_key_exists($after, $this->datasequences)===false) {
                    throw new IdentifierNotFoundException("Datasequence {$after} to add after is not found");
                }
                $after = array_search($after, array_keys($this->datasequences));
            }
            if (is_int($after)===false) {
                // String check is done by above code
                throw new \InvalidArgumentException("parameter after should be an integer or string");
            }
            $this->datasequences = array_merge(
                array_slice(
                    $this->datasequences,
                    0,
                    $after+1
                ),
                array(
                    $identifier => $datasequence
                ),
                array_slice(
                    $this->datasequences,
                    $after+1
                )
            );

        }

        $this->datasequences[$identifier] = $datasequence;
        return $this->datasequences[$identifier];

    }

    /** Fleunt Interfaces **/

    public function x()
    {
        return $this->xaxis;
    }

    /**
     * @return Axis|null
     */
    public function y()
    {
        return $this->yaxis;
    }

    /**
     *
     * Select a datasequence
     *
     * @param string|numeric $identifier
     * @throws \InvalidArgumentException
     * @throws Exceptions\IdentifierNotFoundException
     * @return datasequence object
     */
    public function datasequence($identifier)
    {
        if (!is_string($identifier) && !is_int($identifier)) {
            throw new \InvalidArgumentException("Identifier should be a string or an integer");
        }
        if (is_int($identifier) && $identifier >= 0 && $identifier < count($this->datasequences)) {
            $identifier = array_keys($this->datasequences);
        }

        if (array_key_exists($identifier, $this->datasequences)) {
            return $this->datasequences[$identifier];
        }
        throw new IdentifierNotFoundException("Datasequence {$identifier} does not exist");
    }

    /** Setters **/

    public function setError($message, $description = "")
    {
        $this->errorMessage = (string)$message;
        $this->errorDescription = (string)$description;
    }

    public function setType($type)
    {
        if (in_array($type, array("bar", "line"))) {
            $this->type = (string)$type;
        } else {
            $this->type = "";
        }
    }

    public function setShowTotals($showTotals)
    {
        $this->showTotals = (string)$showTotals;
    }

    public function setTitle($title)
    {
        $this->title = (string)$title;
    }

    public function setRefresh($refresh)
    {
        if ($refresh < 15) {
            throw new \Exception("IllegalValue");
        }

        $this->refresh = (int)$refresh;
    }


    /** GETTERS **/
    public function getType()
    {
        return $this->type;
    }

    public function getShowTotals()
    {
        return $this->showTotals;
    }

    public function getTitle()
    {
        return $this->title;
    }


    public function getRefresh()
    {
        return $this->refresh;
    }

    public function __toJson()
    {
        $tmp = new \stdClass();

        $tmp->title = $this->getTitle();
        $tmp->refreshEveryNSeconds = $this->getRefresh();
        $tmp->xAxis = $this->xaxis->__toJson();
        $tmp->yAxis = $this->yaxis->__toJson();
        /* * /
                $tmp->error = new \stdClass();
                $tmp->error->message= " oh no";
                $tmp->error->detail = " Broken";
        /* */
        if ($this->getShowTotals()) {
            $tmp->total = true;
        }
        if ($this->getType() != '') {
            $tmp->type = $this->getType();
        }
        $tmp->datasequences = array();
        foreach ($this->datasequences as $dataseuence) {
            array_push($tmp->datasequences, $dataseuence->__toJson());
        }
        return $tmp;
    }

    public function output()
    {
        return json_encode(array("graph" => $this->__toJson()));
    }
}
