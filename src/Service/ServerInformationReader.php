<?php

namespace App\Service;

use App\Filters\ServerInformationFilter;
use App\Interface\SearchDTOInterface;
use App\Service\Search\Search;
use OverflowException;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class ServerInformationReader extends ExcelReader
{
    const START_ROW= 2;

    const START_COLUMN= "A";

    const END_COLUMN = "E";

    public function __construct(private readonly Search $searches)
    {
    }

    /**
     * @return array
     * @throws Exception
     */
    public function readServerInformation(SearchDTOInterface $search, int $startRow = self::START_ROW): array
    {
        try {
            /** @phpstan-ignore-next-line */
            $limit = $search->getLimit();

            if ($search->getStartRow() && $search->getStartRow() != 0) {
                $startRow = $search->getStartRow();
            }
            $searchResult = [];
            $lastSearchedKey = 0;
            $i = 1;
            while (1) {
                $serverInformationData = $this->readServerDataFromXlsx(
                    $startRow,
                    self::START_COLUMN,
                    self::END_COLUMN,
                    $limit
                );
                if (!$serverInformationData) {
                    break;
                }
                $lastSearchedKey = array_key_last($serverInformationData);

                foreach ($serverInformationData as $key => $data) {
                    $data = array_values($data);
                    if (!$this->searches->run($data, $search)) {
                        unset($serverInformationData[$key]);
                        $i++;
                        if ($i > 1000) {
                            throw new OverflowException('Longer Loop, Terminated after 1000 loops');
                        }
                        continue;
                    }

                    $searchResult[$key] = $data;
                    unset($serverInformationData[$key]);

                    if (count($searchResult) === $limit) {
                        $lastSearchedKey = $key;
                        break;
                    }
                }

                if (count($searchResult) === $limit) {
                    break;
                }
                $startRow = $lastSearchedKey + 1;
            }

            return [
                'serverInformation' => [
                    'items' => array_values($searchResult),
                    'lastRow' => $lastSearchedKey
                ],
            ];
        } catch (Exception | OverflowException $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function readServerDataFromXlsx(int $startRow, string $startColumn, string $endColumn, int $limit): array
    {
        return $this->read(
            new ServerInformationFilter($startRow, $startRow + $limit),
            $startColumn,
            $endColumn,
            $startRow
        );
    }
}