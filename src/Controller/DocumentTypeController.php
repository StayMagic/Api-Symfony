<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DocumentTypeController extends AbstractController
{
    #[Route('/api/patient/document-types', methods: ['GET'])]
    public function getDocumentType(Connection $connection): JsonResponse
    {
        // Consulta SQL directa a la base de datos
        $documentTypes = $connection->fetchAllAssociative("SELECT id, label FROM document_type");

        return $this->json($documentTypes);
    }
}