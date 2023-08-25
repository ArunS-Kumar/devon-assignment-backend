<?php

namespace App\Filters;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class LocationInformationFilter implements IReadFilter
{
    private $columns  = [];

    public function __construct($columns) {
        $this->columns  = $columns;
    }

    public function readCell($columnAddress, $row, $worksheetName = '') {
        if (in_array($columnAddress, $this->columns)) {
            return true;
        }
        return false;
    }
}
