<?php

namespace App\Tests\Unit\Service\Search;

use App\DTO\SearchDTO;
use App\Interface\SearchDTOInterface;
use App\Service\Search\StorageSearch;
use PHPUnit\Framework\TestCase;

class StorageSearchTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->storage = new StorageSearch();
    }

    /**
     * @dataProvider storageSearchProvider
     */
    public function testSearch(array $data, SearchDTOInterface $search, bool $expected): void
    {
        $actual = $this->storage->search($data, $search);
        $this->assertEquals($expected, $actual);
    }

    public function storageSearchProvider(): iterable
    {
        yield 'storage search TB with false return' => [
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
            'expected' => false,
        ];

        yield 'storage search TB with true return' => [
            'data' => [
                'Dell R210Intel Xeon X3440',
                '16GBDDR3',
                '2x2TBSATA2',
                'AmsterdamAMS-01',
                '€49.99'
            ],
            'search' => new SearchDTO(
                '8TB',
                'SAS',
                'Washington D.C.WDC-01',
                '2GB, 64GB, 32GB, 16GB',
                '100',
                '0'
            ),
            'expected' => true,
        ];

        yield 'storage search GB with true return' => [
            'data' => [
                'Dell R210Intel Xeon X3440',
                '16GBDDR3',
                '2x200GBSATA2',
                'AmsterdamAMS-01',
                '€49.99'
            ],
            'search' => new SearchDTO(
                '1TB',
                'SAS',
                'Washington D.C.WDC-01',
                '2GB, 64GB, 32GB, 16GB',
                '100',
                '0'
            ),
            'expected' => true,
        ];

        yield 'storage search GB with false return' => [
            'data' => [
                'Dell R210Intel Xeon X3440',
                '16GBDDR3',
                '2x250GBSATA2',
                'AmsterdamAMS-01',
                '€49.99'
            ],
            'search' => new SearchDTO(
                '250GB',
                'SAS',
                'Washington D.C.WDC-01',
                '2GB, 64GB, 32GB, 16GB',
                '100',
                '0'
            ),
            'expected' => false,
        ];
    }

    /**
     * @dataProvider storageConvertRamIntoGbProvider
     */
    public function testConvertRamIntoGb(string $ram, int $expected): void
    {
        $actual = $this->storage->convertRamIntoGb($ram);
        $this->assertEquals($expected, $actual);
    }

    public function storageConvertRamIntoGbProvider(): iterable
    {
        yield 'ram string with TB' => [
            'ram' => '12TB',
            'expected' => 12000
        ];

        yield 'ram string with GB' => [
            'ram' => '500GB',
            'expected' => 500
        ];
    }
}