<?php

namespace App\Interface;

interface SearchValueInterface
{
    public function search(array $data, SearchInterface $search): bool;

}