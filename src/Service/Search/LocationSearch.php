<?php

namespace App\Service\Search;

use App\Interface\SearchDTOInterface;
use App\Interface\SearchValueInterface;

class LocationSearch implements SearchValueInterface
{
    const KEY = 'D';
    public function search(array $data, SearchDTOInterface $search): bool
    {
        return str_contains($data[self::KEY], $search->getLocation());
    }
}