<?php

namespace themachinarium\MacherExcel\Exports;

abstract class AbstractExport
{
    abstract public function __construct($dataType, array $ids);
}
