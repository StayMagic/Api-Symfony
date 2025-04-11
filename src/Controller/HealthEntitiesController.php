<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse; 
use Symfony\Component\Routing\Annotation\Route;

class HealthEntitiesController extends AbstractController
{
    #[Route('/api/health-entities', methods: ['GET'])]
    public function getHealthEntities(Connection $connection): JsonResponse
    {
        $healthEntities = $connection->fetchAllAssociative("SELECT id, name FROM health_entities");
        return $this->json($healthEntities);
    }
}
