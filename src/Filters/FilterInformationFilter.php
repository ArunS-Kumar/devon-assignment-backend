<?php

namespace App\Filters;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class FilterInformationFilter implements IReadFilter
{
    public function __construct(private readonly int $startRow, private readonly int $endRow)
    {
    }

    public function readCell($columnAddress, $row, $worksheetName = ''): bool
    {
        if (($row == 1) || ($row >= $this->startRow && $row <= $this->endRow)) {
            if (in_array($columnAddress, range('G', 'I'))) {
                return true;
            }
        }

        return false;
    }

}