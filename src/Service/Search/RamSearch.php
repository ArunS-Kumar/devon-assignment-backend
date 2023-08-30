<?php

namespace App\Service\Search;

use App\Interface\SearchDTOInterface;
use App\Interface\SearchValueInterface;

class RamSearch implements SearchValueInterface
{
    const KEY = '1';
    public function search(array $data, SearchDTOInterface $search): bool
    {
        /** @phpstan-ignore-next-line */
        foreach (explode(",", $search->getRam())  as $ram) {
            if ( mb_substr(trim($data[self::KEY]), 0, strlen(trim($ram))) ==
                mb_substr(trim($ram), 0, strlen(trim($ram)))) {
                return true;
            }
        }
        return false;
    }
}