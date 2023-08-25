<?php

namespace App\Service;

use App\Filters\ServerInformationFilter;
use App\Interface\SearchDTOInterface;
use App\Service\Search\Search;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class ServerInformationReader extends ExcelReader
{
    const START_ROW= 2;

    const START_COLUMN= "A";

    const END_COLUMN = "E";

    public function __construct()
    {
        $this->search = new Search();
    }

    /**
     * @throws Exception
     */
    public function readServerInformation(SearchDTOInterface $search, int $startRow = self::START_ROW): array
    {
        $searchResult = [];
        while (1) {
            $serverInformationData = $this->readServerDataFromXlsx(
                $startRow,
                self::START_COLUMN,
                self::END_COLUMN,
                $search->getLimit()
            );
            $lastSearchedKey = array_key_last($serverInformationData);
            if (!$serverInformationData) {
                break;
            }

            foreach ($serverInformationData as $key => $data) {

                if (!$this->search->run($data, $search)) {
                    unset($serverInformationData[$key]);
                    continue;
                }

                $searchResult[$key] = $serverInformationData[$key];
                unset($serverInformationData[$key]);

                if (count($searchResult) === $search->getLimit()) {
                    $lastSearchedKey = $key;
                    break;
                }
            }

            if (count($searchResult) === $search->getLimit()) {
                break;
            }
            $startRow = $lastSearchedKey + 1;
        }

        return [
            'serverInformation' => [
                'items' => $searchResult,
                'lastSearchedKey' => $lastSearchedKey,
                'totalCount' => count($searchResult)
            ],
        ];
    }

    private function readServerDataFromXlsx(int $startRow, string $startColumn, string $endColumn, int $limit)
    {
        return $this->read(
            new ServerInformationFilter($startRow, $startRow + $limit),
            $startColumn,
            $endColumn,
            $startRow
        );
    }
}