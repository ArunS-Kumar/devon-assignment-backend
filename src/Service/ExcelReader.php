<?php

namespace App\Service;

use App\Interface\ReaderInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class ExcelReader implements ReaderInterface
{
    /**
     * @throws Exception
     */
    public function read(IReadFilter $readFilter, string $startColumn, string $endColumn, int $startRow, int $endRow = null): array
    {
        $spreadsheet = IOFactory::createReader(ReaderInterface::FILE_TYPE)
            ->setReadFilter($readFilter)
            ->load(ReaderInterface::FILE_NAME)
            ->getActiveSheet();

        if (!$endRow) {
            $endRow = $spreadsheet->getHighestRow();
        }
        $range = $this->getRange($startColumn, $endColumn, $startRow, $endRow);

        return $spreadsheet->rangeToArray($range, null, true, true, true);
    }

    private function getRange(string $startColumn, string $endColumn, int $startRow, int $endRow): string
    {
        return "$startColumn$startRow:$endColumn$endRow";
    }
}
