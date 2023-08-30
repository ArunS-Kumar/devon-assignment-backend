<?php

namespace App\Service\Search;

use App\Interface\SearchDTOInterface;
use App\Interface\SearchValueInterface;

class StorageSearch implements SearchValueInterface
{
    const KEY = '2';
    public function search(array $data, SearchDTOInterface $search): bool
    {
        /** @phpstan-ignore-next-line */
        $storage = $search->getStorage();

        $searchRam = $this->convertRamIntoGb($storage);
        $dataRamArray = explode('x', $data[self::KEY]);
        $dataRam = (int) $dataRamArray[0] * $this->convertRamIntoGB($dataRamArray[1]);

        if ($dataRam <= $searchRam || !$storage) {
            return true;
        }

        return false;
    }

    public function convertRamIntoGb(string $ram): int {
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