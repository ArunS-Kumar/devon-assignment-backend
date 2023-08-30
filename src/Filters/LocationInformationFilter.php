<?php

namespace App\Filters;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class LocationInformationFilter implements IReadFilter
{
    /**
     * @param array<int, string> $columns
     */
    public function __construct(private readonly array $columns = []) {
    }

    public function readCell($columnAddress, $row, $worksheetName = ''): bool
    {
        if (in_array($columnAddress, $this->columns)) {
            return true;
        }
        return false;
    }
}
