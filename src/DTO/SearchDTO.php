<?php

namespace App\DTO;

use App\Interface\SearchDTOInterface;

class SearchDTO implements SearchDTOInterface
{
    public function __construct(
        private ?string $storage,
        private ?string $hardDiskType,
        private ?string $location,
        private ?string $ram,
        private int $limit,
        private ?int $startRow = 0
    ) {
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return string|null
     */
    public function getRam(): ?string
    {
        return $this->ram;
    }

    /**
     * @param string|null $ram
     */
    public function setRam(?string $ram): void
    {
        $this->ram = $ram;
    }

    /**
     * @return string|null
     */
    public function getStorage(): ?string
    {
        return $this->storage;
    }

    /**
     * @param string|null $storage
     */
    public function setStorage(?string $storage): void
    {
        $this->storage = $storage;
    }

    /**
     * @return string|null
     */
    public function getHardDiskType(): ?string
    {
        return $this->hardDiskType;
    }

    /**
     * @param string|null $hardDiskType
     */
    public function setHardDiskType(?string $hardDiskType): void
    {
        $this->hardDiskType = $hardDiskType;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string|null $location
     */
    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return int|null
     */
    public function getStartRow(): ?int
    {
        return $this->startRow;
    }

    /**
     * @param int|null $startRow
     */
    public function setStartRow(?int $startRow): void
    {
        $this->startRow = $startRow;
    }
}
