<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse; 
use Symfony\Component\Routing\Annotation\Route;

class SpecialtyController extends AbstractController
{
    #[Route('/api/especialidad', methods: ['GET'])]
    public function getEspeciality(Connection $connection): JsonResponse
    {
        $specialtys = $connection->fetchAllAssociative("SELECT id, name FROM specialty");
        return $this->json($specialtys);
    }
}
