<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse; 
use Symfony\Component\Routing\Annotation\Route;

class RegimeController extends AbstractController
{
    #[Route('/api/regime', methods: ['GET'])]
    public function getRegime(Connection $connection): JsonResponse
    {
        $regimes = $connection->fetchAllAssociative("SELECT id, name FROM regime");
        return $this->json($regimes);
    }
}
