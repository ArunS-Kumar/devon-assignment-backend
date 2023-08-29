<?php

namespace App\Tests\Unit\Service\Search;

use App\DTO\SearchDTO;
use App\Interface\SearchDTOInterface;
use App\Service\Search\HardDiskTypeSearch;
use App\Service\Search\LocationSearch;
use App\Service\Search\RamSearch;
use App\Service\Search\Search;
use App\Service\Search\StorageSearch;
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    /**
     * @dataProvider searchProvider
     */
    public function testRun(array $data, SearchDTOInterface $search, array $returnValues, bool $expected): void
    {
        $locationSearch = $this->createMock(LocationSearch::class);
        $hardDiskTypeSearch = $this->createMock(HardDiskTypeSearch::class);
        $ramSearch = $this->createMock(RamSearch::class);
        $storageSearch = $this->createMock(StorageSearch::class);

        $locationSearch->method('search')->willReturn($returnValues['locationSearch']);
        $hardDiskTypeSearch->method('search')->willReturn($returnValues['hardDiskTypeSearch']);
        $ramSearch->method('search')->willReturn($returnValues['ramSearch']);
        $storageSearch->method('search')->willReturn($returnValues['storageSearch']);

        $search = new Search(
            $locationSearch,
            $hardDiskTypeSearch,
            $ramSearch,
            $storageSearch
        );

        $actual = $search->run($data, $search);
        $this->assertEquals($expected, $actual);
    }

    public function searchProvider(): iterable
    {
        yield 'filter with all search return true' => [
            'data' => [
                'Dell R210Intel Xeon X3440',
                '16GBDDR3',
                '2x2TBSATA2',
                'AmsterdamAMS-01',
                '€49.99'
            ],
            'search' => new SearchDTO(
                '2TB',
                'SAS',
                'Washington D.C.WDC-01',
                '2GB, 64GB, 32GB, 16GB',
                '100',
                '0'
            ),
            'returnValues' => [
                'locationSearch' => true,
                'hardDiskTypeSearch' => true,
                'ramSearch' => true,
                'storageSearch' => true
             ],
            'expected' => true,
        ];

        yield 'filter with all search return false' => [
            'data' => [
                'Dell R210Intel Xeon X3440',
                '16GBDDR3',
                '2x2TBSATA2',
                'AmsterdamAMS-01',
                '€49.99'
            ],
            'search' => new SearchDTO(
                '2TB',
                'SAS',
                'Washington D.C.WDC-01',
                '2GB, 64GB, 32GB, 16GB',
                '100',
                '0'
            ),
            'returnValues' => [
                'locationSearch' => false,
                'hardDiskTypeSearch' => false,
                'ramSearch' => false,
                'storageSearch' => false
            ],
            'expected' => false,
        ];

        yield 'filter with any one search return false' => [
            'data' => [
                'Dell R210Intel Xeon X3440',
                '16GBDDR3',
                '2x2TBSATA2',
                'AmsterdamAMS-01',
                '€49.99'
            ],
            'search' => new SearchDTO(
                '2TB',
                'SAS',
                'Washington D.C.WDC-01',
                '2GB, 64GB, 32GB, 16GB',
                '100',
                '0'
            ),
            'returnValues' => [
                'locationSearch' => true,
                'hardDiskTypeSearch' => true,
                'ramSearch' => false,
                'storageSearch' => true
            ],
            'expected' => false,
        ];
    }
}