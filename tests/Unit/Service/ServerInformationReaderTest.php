<?php

namespace App\Tests\Unit\Service;

use App\DTO\SearchDTO;
use App\Interface\SearchDTOInterface;
use App\Service\Search\HardDiskTypeSearch;
use App\Service\Search\LocationSearch;
use App\Service\Search\RamSearch;
use App\Service\Search\Search;
use App\Service\Search\StorageSearch;
use App\Service\ServerInformationReader;
use OverflowException;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PHPUnit\Framework\TestCase;

class ServerInformationReaderTest extends TestCase
{
    /**
     * @dataProvider serverInformationDataProvider
     *
     * @throws Exception
     */
    public function testReadServerInformation(string $serverInformationData, bool $searchResult, SearchDTOInterface $searchData, array $expected): void
    {
        $locationSearch = $this->createMock(LocationSearch::class);
        $hardDiskTypeSearch = $this->createMock(HardDiskTypeSearch::class);
        $ramSearch = $this->createMock(RamSearch::class);
        $storageSearch = $this->createMock(StorageSearch::class);

        $locationSearch->method('search')->willReturn($searchResult);
        $hardDiskTypeSearch->method('search')->willReturn($searchResult);
        $ramSearch->method('search')->willReturn($searchResult);
        $storageSearch->method('search')->willReturn($searchResult);

        $search = new Search(
            $locationSearch,
            $hardDiskTypeSearch,
            $ramSearch,
            $storageSearch
        );

        $serverInformationReader = $this->getMockBuilder(ServerInformationReader::class)
            ->setConstructorArgs([$search])
            ->onlyMethods(['readServerDataFromXlsx'])
            ->getMock();

        $serverInformation  = json_decode(file_get_contents($serverInformationData), true);
        $serverInformationReader
            ->method('readServerDataFromXlsx')
            ->willReturn($serverInformation);

        $actual = $serverInformationReader->readServerInformation($searchData, 1);
        $this->assertEquals($expected, $actual);
    }

    public function serverInformationDataProvider(): iterable
    {
        yield 'server information with search result true' => [
            'serverInformationData' => __DIR__ . '/../../Data/server-information.json',
            'searchResult' => true,
            'searchData' => new SearchDTO(
                '2TB',
                'SAS',
                'Washington D.C.WDC-01',
                '2GB, 64GB, 32GB, 16GB',
                '10',
                '0'
            ),
            'expected' => [
                "serverInformation" => [
                    "items" =>  [
                        0 =>  [
                            0 => "Dell R210Intel Xeon X3440",
                            1 => "16GBDDR3",
                            2 => "2x2TBSATA2",
                            3 => "AmsterdamAMS-01",
                            4 => "€49.99",
                          ],
                          1 =>  [
                            0 => "HP DL180G62x Intel Xeon E5620",
                            1 => "32GBDDR3",
                            2 => "8x2TBSATA2",
                            3 => "AmsterdamAMS-01",
                            4 => "€119.00",
                          ],
                          2 =>  [
                            0 => "HP DL380eG82x Intel Xeon E5-2420",
                            1 => "32GBDDR3",
                            2 => "8x2TBSATA2",
                            3 => "AmsterdamAMS-01",
                            4 => "€131.99",
                          ],
                          3 =>  [
                            0 => "RH2288v32x Intel Xeon E5-2650V4",
                            1 => "128GBDDR4",
                            2 => "4x480GBSSD",
                            3 => "AmsterdamAMS-01",
                            4 => "€227.99",
                          ],
                          4 =>  [
                            0 => "RH2288v32x Intel Xeon E5-2620v4",
                            1 => "64GBDDR4",
                            2 => "4x2TBSATA2",
                            3 => "AmsterdamAMS-01",
                            4 => "€161.99",
                          ],
                          5 =>  [
                            0 => "Dell R210-IIIntel Xeon E3-1230v2",
                            1 => "16GBDDR3",
                            2 => "2x2TBSATA2",
                            3 => "AmsterdamAMS-01",
                            4 => "€72.99",
                          ],
                          6 =>  [
                            0 => "HP DL380pG82x Intel Xeon E5-2650",
                            1 => "64GBDDR3",
                            2 => "8x2TBSATA2",
                            3 => "AmsterdamAMS-01",
                            4 => "€179.99",
                          ],
                          7 =>  [
                            0 => "IBM X36302x Intel Xeon E5620",
                            1 => "32GBDDR3",
                            2 => "8x2TBSATA2",
                            3 => "AmsterdamAMS-01",
                            4 => "€106.99",
                          ],
                          8 =>  [
                            0 => "HP DL120G7Intel G850",
                            1 => "4GBDDR3",
                            2 => "4x1TBSATA2",
                            3 => "AmsterdamAMS-01",
                            4 => "€39.99",
                          ],
                          9 =>  [
                            0 => "Dell R730XD2x Intel Xeon E5-2667v4",
                            1 => "128GBDDR4",
                            2 => "2x120GBSSD",
                            3 => "AmsterdamAMS-01",
                            4 => "€364.99",
                          ],
                        ],
                        "lastRow" => 11,
                      ],
                ],
        ];

        yield 'server information with search result false' => [
            'serverInformationData' => __DIR__ . '/../../Data/server-information.json',
            'searchResult' => false,
            'searchData' => new SearchDTO(
                '2TB',
                'SAS',
                'Washington D.C.WDC-01',
                '2GB, 64GB, 32GB, 16GB',
                '10',
                '0'
            ),
            'expected' => ['error' => 'Longer Loop, Terminated after 1000 loops'],
        ];
    }
}