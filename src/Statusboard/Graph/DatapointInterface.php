<?php

namespace Statusboard\Graph;

interface DatapointInterface
{

    /**
     * Return title as string
     *
     * @return string
     */
    public function getTitle();

    /**
     * Return value as float
     *
     * @return float value
     */
    public function getValue();
}
