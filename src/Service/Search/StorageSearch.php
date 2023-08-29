<?php

namespace App\Service\Search;

use App\Interface\SearchDTOInterface;
use App\Interface\SearchValueInterface;

class StorageSearch implements SearchValueInterface
{
    const KEY = '2';
    public function search(array $data, SearchDTOInterface $search): bool
    {
        $searchRam = $this->convertRamIntoGb($search->getStorage());
        $dataRamArray = explode('x', $data[self::KEY]);
        $dataRam = (int) $dataRamArray[0] * $this->convertRamIntoGB($dataRamArray[1]);

        if ($dataRam <= $searchRam || !$search->getStorage()) {
            return true;
        }

        return false;
    }

    private function convertRamIntoGb(string $ram): int {
        if (str_contains($ram, 'TB')) {
            $searchRam = $this->calculateTBintoGB( (int) explode('TB', $ram)[0]);
        } else {
            $searchRam = (int) explode('GB', $ram)[0];
        }

        return $searchRam;
    }

    private function calculateTBintoGB(int $ram): int {
        return 1000 * (int) $ram;
    }
}