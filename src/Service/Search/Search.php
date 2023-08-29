<?php

namespace App\Service\Search;

use App\Interface\SearchDTOInterface;

class Search implements SearchDTOInterface
{
    public function __construct(
        private readonly LocationSearch     $location,
        private readonly HardDiskTypeSearch $hardDisk,
        private readonly RamSearch          $ram,
        private readonly StorageSearch      $storage,
    ) {
    }

    public function run(array $data, SearchDTOInterface $searchValue): bool
    {
        $checkLocation = $this->location->search($data, $searchValue);
        $checkHardDiskType = $this->hardDisk->search($data, $searchValue);
        $checkRam = $this->ram->search($data, $searchValue);
        $checkStorage = $this->storage->search($data, $searchValue);

        if ($checkLocation && $checkHardDiskType && $checkRam && $checkStorage) {
            return true;
        }

        return false;
    }
}