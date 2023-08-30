<?php

namespace App\Service\Search;

use App\Interface\SearchDTOInterface;
use App\Interface\SearchValueInterface;

class LocationSearch implements SearchValueInterface
{
    const KEY = '3';

    /**
     * @param array<string> $data
     * @param SearchDTOInterface $search
     * @return bool
     */
    public function search(array $data, SearchDTOInterface $search): bool
    {
        /** @phpstan-ignore-next-line */
        $trimmedLocation = trim($search->getLocation());
        if ($trimmedLocation === '') {
            return true;
        }

        return str_contains(trim($data[self::KEY]), $trimmedLocation);
    }
}