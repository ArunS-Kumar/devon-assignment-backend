<?php

namespace App\Interface;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

interface ReaderInterface
{
    const FILE_NAME = './data/LeaseWeb_servers_filters_assignment_data.xlsx';

    const FILE_TYPE = 'Xlsx';

    /**
     * @return array<int, string>
     */
    public function read(IReadFilter $readFilter, string $startColumn, string $endColumn, int $startRow, int $endRow = null): array;
}
