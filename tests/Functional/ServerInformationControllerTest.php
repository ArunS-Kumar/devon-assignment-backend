<?php

namespace App\Tests\Functional;

use App\DTO\SearchDTO;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServerInformationControllerTest extends WebTestCase
{
    private const ENDPOINT_URL = '/server-information';

    /**
     * @dataProvider apiDataProvider
     *
     * @throws Exception
     */
    public function testSuccess($request, $responseCode)
    {
        $client = static::createClient();
        $client->request('POST', self::ENDPOINT_URL, [], [], [], json_encode($request));

        if ($responseCode == 200) {
            $this->assertResponseIsSuccessful();
        }
        $this->assertResponseStatusCodeSame($responseCode);
    }

    public function apiDataProvider(): iterable
    {
        yield 'success api' => [
            'request' => [
                'storage' => '8TB',
                'harddisk_type' => 'SATA',
                'location' => '',
                'ram' => '',
                'limit' => 10,
                'start_row' => 0,
            ],
            'responseCode' => 200,
        ];

        yield 'failed api' => [
            'request' => [
                'storage' => '8TB',
                'harddisk_type' => 'SATA',
                'location' => '',
                'ram' => '',
            ],
            'responseCode' => 500,
        ];
    }
}