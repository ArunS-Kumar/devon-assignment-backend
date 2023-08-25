<?php

namespace App\DTO;

use App\Interface\SearchDTOInterface;

class SearchDTO implements SearchDTOInterface
{
    private ?string $storage;

    private ?string $hardDiskType;

    private ?string $location;

    private ?string $ram;

    private int $limit;

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

}