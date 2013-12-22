<?php

namespace Humsie\Statusboard\Graph;

class Axis
{

    const AXIS_X = 1;
    const AXIS_Y = 2;

    protected $minValue = null;
    protected $maxValue = null;

    protected $prefix = "";
    protected $suffix = "";

    protected $hide = false;
    protected $scale = null;

    protected $showEveryLabel = true;

    public function __construct($axis)
    {
        if ($axis === static::AXIS_X || $axis === static::AXIS_Y) {
            $this->axis = $axis;
            return $this;
        }
        throw new \InvalidArgumentException("Invalid Axis given");
    }

    public function setMinValue($value)
    {
        $this->minValue = (float)$value;
        return $this;
    }

    public function setMaxValue($value)
    {
        $this->maxValue = (float)$value;
        return $this;
    }

    public function setHide($state)
    {
        $this->hide = ($state ? true : false);
        return $this;
    }

    public function setShowEveryLabel($showEveryLabel)
    {
        $this->showEveryLabel = ($showEveryLabel ? true : false);
        return $this;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = (string)$prefix;
        return $this;
    }

    public function setSuffix($suffix)
    {
        $this->suffix = (string)$suffix;
        return $this;
    }

    public function setScale($scale)
    {
        $this->scale = (int)$scale;
        return $this;
    }

    public function getMinValue()
    {
        return $this->minValue;
    }

    public function getMaxValue()
    {
        return $this->maxValue;
    }

    public function getHide()
    {
        return $this->hide;
    }

    public function getShowEveryLabel()
    {
        return $this->showEveryLabel;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function getSuffix()
    {
        return $this->suffix;
    }

    public function getScale()
    {
        return $this->scale;
    }

    protected function is($axis)
    {
        return ($this->axis === $axis);
    }

    public function __toJson()
    {
        $tmp = new \stdClass();

        if (!is_null($this->getMinValue()) && $this->is(static::AXIS_Y)) {
            $tmp->minValue = $this->getMinValue();
        }

        if (!is_null($this->getMaxValue()) && $this->is(static::AXIS_Y)) {
            $tmp->maxValue = $this->getMaxValue();
        }
        if (!is_null($this->getHide())) {
            $tmp->hide = $this->getHide();
        }

        if (($this->getPrefix() != "" || $this->getSuffix() != "") && $this->is(static::AXIS_Y)) {
            $tmp->units = new \stdClass();

            if ($this->getPrefix() != "") {
                $tmp->units->prefix = $this->getPrefix();
            }
            if ($this->getSuffix() != "") {
                $tmp->units->suffix = $this->getSuffix();
            }
        }

        if (!is_null($this->getScale()) && $this->is(static::AXIS_Y)) {
            $tmp->scaleTo = $this->getScale();
        }

        if (!is_null($this->getShowEveryLabel()) && $this->is(static::AXIS_X)) {
            $tmp->showEveryLabel = $this->getShowEveryLabel();
        }

        return $tmp;
    }
}
