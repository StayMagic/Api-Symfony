<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthEntityController extends AbstractController
{
    #[Route('/api/health-entities', name: 'api_health_entities', methods: ['GET'])]
    public function getHealthEntities(Connection $connection): JsonResponse
    {
        try {
            // Verifica si la tabla existe
            $schemaManager = $connection->createSchemaManager();
            if (!$schemaManager->tablesExist(['health_entities'])) {
                return new JsonResponse(
                    ['error' => 'La tabla health_entities no existe'], 
                    404
                );
            }

            // Consulta con parámetros seguros
            $sql = "SELECT id, name FROM health_entities ORDER BY name ASC";
            $stmt = $connection->prepare($sql);
            $result = $stmt->executeQuery();
            
            return new JsonResponse($result->fetchAllAssociative());
            
        } catch (\Exception $e) {
            // Log del error
            error_log($e->getMessage());
            
            return new JsonResponse(
                ['error' => 'Error en el servidor: ' . $e->getMessage()],
                500
            );
        }
    }
}
