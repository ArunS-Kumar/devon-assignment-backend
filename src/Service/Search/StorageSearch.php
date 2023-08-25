<?php

namespace App\Service\Search;

use App\Interface\SearchDTOInterface;
use App\Interface\SearchValueInterface;

class StorageSearch implements SearchValueInterface
{
    const KEY = 'C';
    public function search(array $data, SearchDTOInterface $search): bool
    {
        return true;
    }
}