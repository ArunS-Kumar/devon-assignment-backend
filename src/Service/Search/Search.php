<?php

namespace App\Service\Search;

use App\Interface\SearchInterface;

class Search
{
    public function run(array $data, SearchInterface $searchValues): bool
    {
        $locationSearch = new LocationSearch();
        $hardDiskTypeSearch = new HardDiskTypeSearch();
        $ramSearch = new RamSearch();

        $checkLocation = $locationSearch->search($data, $searchValues);
        $checkHardDiskType = $hardDiskTypeSearch->search($data, $searchValues);
        $checkRam = $ramSearch->search($data, $searchValues);

        if ($checkLocation && $checkHardDiskType && $checkRam) {
            return true;
        }

        return false;
    }
}