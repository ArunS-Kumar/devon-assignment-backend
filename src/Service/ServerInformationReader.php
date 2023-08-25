<?php

namespace App\Service;

use App\Filters\ServerInformationFilter;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class ServerInformationReader extends ExcelReader
{
    const START_ROW= 2;

    const START_COLUMN= "A";

    const END_COLUMN = "E";

    const CHUNK_SIZE = 15;

    /**
     * @throws Exception
     */
    public function readServerInformation(array $filter, int $startRow = self::START_ROW): array
    {
        $searchResult = [];
        $lastSearchedKey = '';
        while (1) {
            $serverInformationData = $this->readServerDataFromXlsx($startRow, self::START_COLUMN, self::END_COLUMN);
            if (!$serverInformationData) {
                break;
            }

            $lastSearchedKey = array_key_last($serverInformationData);
            foreach ($serverInformationData as $key => $data) {

                if (!str_contains($data['C'], $filter['storage']) ||
                    !str_contains($data['C'], $filter['harddisk_type']) ||
                    !str_contains($data['D'], $filter['location']) ||
                    !$this->checkRamFilter($data['B'], $filter['ram'])
                ) {
                    unset($serverInformationData[$key]);
                    continue;
                }

                $searchResult[$key] = $serverInformationData[$key];
                unset($serverInformationData[$key]);

                if (count($searchResult) === self::CHUNK_SIZE) {
                    $lastSearchedKey = $key;
                    break;
                }
            }

            if (count($searchResult) === self::CHUNK_SIZE) {
                break;
            }
            $startRow = $lastSearchedKey + 1;
        }

        return [
            'serverInformation' => $searchResult,
            'lastSearchedKey' => $lastSearchedKey
        ];
    }

    private function readServerDataFromXlsx(int $startRow, string $startColumn, string $endColumn)
    {
        return $this->read(
            new ServerInformationFilter($startRow, $startRow + self::CHUNK_SIZE),
            $startColumn,
            $endColumn,
            $startRow
        );
    }

    private function checkRamFilter(string $ramData, string $ramFilter): bool
    {
        foreach (explode(",",$ramFilter)  as $data) {
            if (str_contains($ramData, $data)) {
                return true;
            }
        }
        return false;
    }


}