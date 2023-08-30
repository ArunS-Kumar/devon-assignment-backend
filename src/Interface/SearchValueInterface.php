<?php

namespace App\Interface;

interface SearchValueInterface
{
    /**
     * @param array<int, string> $data
     * @param SearchDTOInterface $search
     * @return bool
     */
    public function search(array $data, SearchDTOInterface $search): bool;

}