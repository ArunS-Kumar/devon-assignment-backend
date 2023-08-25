<?php

namespace App\Service\Search;

use App\Interface\SearchDTOInterface;
use App\Interface\SearchValueInterface;

class HardDiskTypeSearch implements SearchValueInterface
{
    const KEY = 'C';
    public function search(array $data, SearchDTOInterface $search): bool
    {
        return str_contains($data[self::KEY], $search->getHardDiskType());
    }
}