<?php

namespace App\Controller;

use App\DTO\SearchDTO;
use App\Service\FilterInformationReader;
use App\Service\ServerInformationReader;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ServerInformationController extends AbstractController
{
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    #[Route('/server-information', name: 'server-information', methods: 'POST')]
    public function serverInformation(
        Request $request,
        SerializerInterface $serializer,
        ServerInformationReader $serverInformationReader,
        FilterInformationReader $filterInformationReader,
        CacheInterface $cache
    ): JsonResponse
    {
        $search = $serializer->deserialize($request->getContent(), SearchDTO::class, 'json');
        $serverInformation = $serverInformationReader->readServerInformation($search);

        // todo -> change cache into raise
        $filterInformation = $cache->get('find-filter-information', function(ItemInterface $item) use ($filterInformationReader) {
            $item->expiresAfter(18000);
            return $filterInformationReader->readFilterInformation();
        });

        // todo -> add collection to pass response
        return new JsonResponse(
            array_merge($serverInformation, $filterInformation)
        );
    }

}