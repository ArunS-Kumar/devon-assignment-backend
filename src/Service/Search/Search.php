<?php

namespace App\Service\Search;

use App\Interface\SearchDTOInterface;

class Search
{
    public function run(array $data, SearchDTOInterface $searchValues): bool
    {
        $locationSearch = new LocationSearch();
        $hardDiskTypeSearch = new HardDiskTypeSearch();
        $ramSearch = new RamSearch();
        $storageSearch = new StorageSearch();

        $checkLocation = $locationSearch->search($data, $searchValues);
        $checkHardDiskType = $hardDiskTypeSearch->search($data, $searchValues);
        $checkRam = $ramSearch->search($data, $searchValues);
        $checkStorage = $storageSearch->search($data, $searchValues);

        if ($checkLocation && $checkHardDiskType && $checkRam && $checkStorage) {
            return true;
        }

        return false;
    }
}