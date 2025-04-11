<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DocumentTypeController extends AbstractController
{
    #[Route('/api/patient/document-types', methods: ['GET'])]
    public function getDocumentTypesForSelect(Connection $connection): JsonResponse
    {
        // Consulta optimizada para select (value = código, label = nombre + descripción)
        $documentTypes = $connection->fetchAllAssociative(
            "SELECT 
                code as value, 
                CONCAT(name, ' - ', description) as label 
             FROM document_type 
             ORDER BY CAST(code AS INTEGER)"
        );

        return $this->json($documentTypes);
    }
}
