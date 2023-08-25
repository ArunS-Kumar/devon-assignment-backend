<?php

namespace App\Controller;

use App\DTO\SearchDTO;
use App\Service\FilterInformationReader;
use App\Service\ServerInformationReader;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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
    #[Route('/server-information', name: 'server-information', methods: 'POST')]
    public function serverInformation(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $search = $serializer->deserialize($request->getContent(), SearchDTO::class, 'json');
        $serverInformation = $this->serverInformationReader->readServerInformation($search);
        $filterInformation = $this->filterInformationReader->readFilterInformation();

        // todo -> add collection to pass response
        return new JsonResponse(
            array_merge($serverInformation, $filterInformation)
        );
    }

}