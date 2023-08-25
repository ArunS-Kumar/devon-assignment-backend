<?php

namespace App\Controller;

use App\Service\FilterInformationReader;
use App\Service\ServerInformationReader;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServerInformationController extends AbstractController
{
    public function __construct(
        public ServerInformationReader $serverInformationReader,
        public FilterInformationReader $filterInformationReader
    ) {
    }

    /**
     * @throws Exception
     */
    #[Route('/server-information', name: 'server-information', methods: 'GET')]
    public function serverInformation(Request $request): JsonResponse
    {
        $filter = [
            'storage' => $request->get('storage'),
            'harddisk_type' => $request->get('harddisk_type'),
            'location' => $request->get('location'),
            'ram' => $request->get('ram')
        ];
        $serverInformation = $this->serverInformationReader->readServerInformation($filter);
        $filterInformation = $this->filterInformationReader->readFilterInformation();

        return new JsonResponse(
            array_merge($serverInformation, $filterInformation)
        );
    }

}