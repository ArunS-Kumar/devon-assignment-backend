<?php

namespace App\Filters;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class ServerInformationFilter implements IReadFilter
{
    public function __construct(private readonly int $startRow, private readonly int $endRow)
    {
    }

    public function readCell($columnAddress, $row, $worksheetName = ''): bool
    {
        if (($row == 1) || ($row >= $this->startRow && $row <= $this->endRow)) {
            if (in_array($columnAddress, range('A', 'E'))) {
                return true;
            }
        }

        return false;
    }
}