<?php

namespace Tu6ge\VoyagerExcel\Tests;

class DemoPolicy
{
    /**
     * Handle all requested permission checks.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return bool
     */
    public function __call($name, $arguments)
    {
        return true;
    }
}
