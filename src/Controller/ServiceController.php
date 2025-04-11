<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse; 
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/api/service', methods: ['GET'])]
    public function getServicio(Connection $connection): JsonResponse
    {
        $services = $connection->fetchAllAssociative("SELECT id, name FROM service");
        return $this->json($services);
    }
}
