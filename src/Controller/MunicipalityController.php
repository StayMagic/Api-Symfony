<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MunicipalityController extends AbstractController
{
    #[Route('/api/municipalities', name: 'get_municipalities_by_department', methods: ['GET'])]
    public function getMunicipalitiesByDepartment(Request $request, Connection $connection): JsonResponse
    {
        $departmentId = $request->query->get('department_id');

        if (!$departmentId) {
            return new JsonResponse(['error' => 'No department ID provided'], 400);
        }

        // Consulta SQL directa
        $sql = "SELECT id, name FROM municipalities WHERE department_id = :department_id";
        $municipalities = $connection->fetchAllAssociative($sql, ['department_id' => $departmentId]);

        return $this->json($municipalities);
    }
}

