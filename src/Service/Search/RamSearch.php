<?php

namespace App\Service\Search;

use App\Interface\SearchInterface;
use App\Interface\SearchValueInterface;

class RamSearch implements SearchValueInterface
{
    const KEY = 'B';
    public function search(array $data, SearchInterface $search): bool
    {
        foreach (explode(",", $search->getRam())  as $ram) {
            if (str_contains($data[self::KEY], $ram)) {
                return true;
            }
        }
        return false;
    }
}