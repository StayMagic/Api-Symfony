<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{
    #[Route('/api/departments', name: 'get_departments', methods: ['GET'])]
    public function getDepartments(Connection $connection): JsonResponse
    {
        // Consulta directa a la base de datos sin entidad
        $departments = $connection->fetchAllAssociative("SELECT id, name FROM departments");

        return $this->json($departments);
    }
}

