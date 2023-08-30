<?php

namespace App\Service\Search;

use App\Interface\SearchDTOInterface;
use App\Interface\SearchValueInterface;

class HardDiskTypeSearch implements SearchValueInterface
{
    const KEY = '2';
    public function search(array $data, SearchDTOInterface $search): bool
    {
        /** @phpstan-ignore-next-line */
        $trimmedHdd = trim($search->getHardDiskType());
        if ($trimmedHdd === '') {
            return true;
        }

        return str_contains(trim($data[self::KEY]), $trimmedHdd);
    }
}