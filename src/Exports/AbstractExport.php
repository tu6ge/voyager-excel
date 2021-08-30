<?php

namespace Tu6ge\VoyagerExcel\Exports;

abstract class AbstractExport
{
    abstract function __construct($dataType, array $ids);
}
