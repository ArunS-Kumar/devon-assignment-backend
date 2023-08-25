<?php

namespace App\Interface;

interface SearchValueInterface
{
    public function search(array $data, SearchDTOInterface $search): bool;

}