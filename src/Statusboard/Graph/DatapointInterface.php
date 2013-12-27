<?php
/**
 * Created by PhpStorm.
 * User: humsie
 * Date: 24-12-13
 * Time: 20:18
 */

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
