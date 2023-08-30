<?php

namespace App\Service;

use App\Filters\FilterInformationFilter;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class FilterInformationReader extends ExcelReader
{
    const START_ROW = 3;

    const END_ROW = 5;

    const START_COLUMN = "G";

    const END_COLUMN = "I";

    /**
     * @return array
     * @throws Exception
     */
    public function readFilterInformation(): array
    {
        $filterInformation = $this->readFilterDataFromXlsx();
        foreach ($filterInformation as $filter) {
            $filterValues[] = [
                'name' => $this->snakeCase($filter['G']),
                'type' => $this->snakeCase($filter['H']),
                'value' => explode(',', $filter['I'])
            ];
        }

        $locationReader = new LocationReader();
        $filterValues[] = $locationReader->readLocation();

        return [
            'filterInformation' => $filterValues
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    private function readFilterDataFromXlsx(): array
    {
        return $this->read(
            new FilterInformationFilter(self::START_ROW, self::END_ROW),
            self::START_COLUMN,
            self::END_COLUMN,
            self::START_ROW,
            self::END_ROW
        );
    }

    /**
     * @param string $input
     * @return string
     */
    function snakeCase(string $input): string {
        /** @phpstan-ignore-next-line */
        return strtolower(preg_replace('/[^A-Za-z0-9]/', '_', preg_replace('/(?<!^)[A-Z]/', '_$0', $input)));
    }
}