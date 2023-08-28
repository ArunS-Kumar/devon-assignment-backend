<?php

namespace App\Service\Search;

use App\Interface\SearchDTOInterface;

class Search
{
    public function __construct(
        private readonly LocationSearch     $location,
        private readonly HardDiskTypeSearch $hardDisk,
        private readonly RamSearch          $ram,
        private readonly StorageSearch      $storage,
    )
    {
    }

    public function run(array $data, SearchDTOInterface $searchValues): bool
    {
        $checkLocation = $this->location->search($data, $searchValues);
        $checkHardDiskType = $this->hardDisk->search($data, $searchValues);
        $checkRam = $this->ram->search($data, $searchValues);
        $checkStorage = $this->storage->search($data, $searchValues);

        if ($checkLocation && $checkHardDiskType && $checkRam && $checkStorage) {
            return true;
        }

        return false;
    }
}