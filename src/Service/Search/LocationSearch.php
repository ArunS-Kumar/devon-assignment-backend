<?php

namespace App\Service\Search;

use App\Interface\SearchInterface;
use App\Interface\SearchValueInterface;

class LocationSearch implements SearchValueInterface
{
    const KEY = 'C';
    public function search(array $data, SearchInterface $search): bool
    {
        return str_contains($data[self::KEY], $search->getStorage());
    }
}