<?php

namespace App\Controller;

use App\Entity\Patient;
use Psr\Log\LoggerInterface; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[Route('/api/patient')]
class PatientController extends AbstractController
{
    #[Route('/', name: 'app_patient_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $patients = $entityManager->getRepository(Patient::class)->findAll();
        $data = [];

        foreach ($patients as $patient) {
            $data[] = [
                'id' => $patient->getId(),
                'documentType' => $patient->getDocumentType(),
                'document' => $patient->getDocument(),
                'firstName' => $patient->getFirstName(),
                'secondName' => $patient->getSecondName(),
                'firstLastName' => $patient->getFirstLastName(),
                'secondLastName' => $patient->getSecondLastName(),
                'birthday' => $patient->getBirthday()->format('Y-m-d'),
                'phone' => $patient->getPhone(),
                'secondPhone' => $patient->getSecondPhone(),
                'department' => $patient->getDepartment(),
                'municipality' => $patient->getMunicipality(),
                'address' => $patient->getAddress(),
                'gender' => $patient->getGender(),
                'bloodGroup' => $patient->getBloodGroup(),
                'rh' => $patient->getRh(),
                'email' => $patient->getEmail()
            ];
        }

        return $this->json($data);
    }

    #[Route('/new', name: 'app_patient_new', methods: ['POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager, 
        ValidatorInterface $validator,
        LoggerInterface $logger
    ): JsonResponse {
        // Decodificar y validar JSON
        try {
            $data = json_decode($request->getContent(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \InvalidArgumentException('JSON inválido');
            }
        } catch (\Exception $e) {
            return $this->json(['error' => 'Datos JSON inválidos'], Response::HTTP_BAD_REQUEST);
        }
    
        // Validación de los datos
        $constraint = new Assert\Collection([
            'fields' => [
                'documentType' => new Assert\NotBlank(),
                'document' => [
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Length(['max' => 20])
                ],
                'firstName' => [
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Length(['max' => 100])
                ],
                'firstLastName' => [
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Length(['max' => 100])
                ],
                'birthday' => [
                    new Assert\NotBlank(),
                    new Assert\Date(),
                    new Assert\LessThan('today')
                ],
                'phone' => [
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Length(['min' => 7, 'max' => 15])
                ],
                'email' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['max' => 180])
                ],
                'gender' => new Assert\NotBlank(),
                'bloodGroup' => new Assert\NotBlank(),
                'rh' => new Assert\NotBlank(),
                'department' => new Assert\NotBlank(),
                'municipality' => new Assert\NotBlank(),
                'address' => new Assert\NotBlank(),
                'processType' => new Assert\NotBlank(),
                'entityHealth' => new Assert\NotBlank(),
                'regime' => new Assert\NotBlank(),
               
                'service' => new Assert\NotBlank(),
                
                // Campos opcionales
                'secondName' => new Assert\Optional([
                    new Assert\Type('string'),
                    new Assert\Length(['max' => 100])
                ]),
                'secondLastName' => new Assert\Optional([
                    new Assert\Type('string'),
                    new Assert\Length(['max' => 100])
                ]),
                'secondPhone' => new Assert\Optional([
                    new Assert\Type('string'),
                    new Assert\Length(['min' => 7, 'max' => 15])
                ]),
                'authorizationNumber' => new Assert\Optional([
                    new Assert\Type('string'),
                    new Assert\Length(['max' => 50])
                ]),
                'imagePath' => new Assert\Optional([
                    new Assert\Type('string'),
                    new Assert\Length(['max' => 255])
                ]),
                'pathImageEPS' => new Assert\Optional([
                    new Assert\Type('string'),
                    new Assert\Length(['max' => 255])
                ]),
                'specialty' => new Assert\Optional([
                    new Assert\Type('string'),
                    new Assert\Length(['max' => 100])
                ]),
                'customHealthEntity' => new Assert\Optional([
                    new Assert\Type('string'),
                    new Assert\Length(['max' => 100])
                ]),
                'cancellationDate' => new Assert\Optional([
                    new Assert\Date(),
                    new Assert\GreaterThan('today')
                ]),
                'reschedulingDate' => new Assert\Optional([
                    new Assert\Date(),
                    new Assert\GreaterThan('today')
                ]),
            ],
            'allowExtraFields' => false, // No permitir campos adicionales
            'missingFieldsMessage' => 'El campo {{ field }} es requerido'
        ]);
    
        $violations = $validator->validate($data, $constraint);
    
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }
    
        try {
            $patient = new Patient();
            $patient->setDocumentType($data['documentType']);
            $patient->setDocument($data['document']);
            $patient->setFirstName(trim($data['firstName']));
            $patient->setSecondName(isset($data['secondName']) ? trim($data['secondName']) : null);
            $patient->setFirstLastName(trim($data['firstLastName']));
            $patient->setSecondLastName(isset($data['secondLastName']) ? trim($data['secondLastName']) : null);
            
            // Procesamiento de fechas con formato específico
            $patient->setBirthday(\DateTime::createFromFormat('Y-m-d', $data['birthday']));
            
            $patient->setPhone($data['phone']);
            $patient->setSecondPhone($data['secondPhone'] ?? null);
            $patient->setDepartment($data['department']);
            $patient->setMunicipality($data['municipality']);
            $patient->setAddress($data['address']);
            $patient->setEmail(strtolower(trim($data['email'])));
            $patient->setGender($data['gender']);
            $patient->setBloodGroup($data['bloodGroup']);
            $patient->setRh($data['rh']);
            $patient->setProcessType($data['processType']);
            $patient->setEntityHealth($data['entityHealth']);
            $patient->setRegime($data['regime']);
           
            $patient->setService($data['service']);
            $patient->setAuthorizationNumber($data['authorizationNumber'] ?? null);
            $patient->setImagePath($data['imagePath'] ?? null);
            $patient->setPathImageEPS($data['pathImageEPS'] ?? null);
            $patient->setSpecialty($data['specialty'] ?? null);
            $patient->setCustomHealthEntity($data['customHealthEntity'] ?? null);
    
            // Fechas opcionales
            if (!empty($data['cancellationDate'])) {
                $patient->setCancellationDate(\DateTime::createFromFormat('Y-m-d', $data['cancellationDate']));
            }
            
            if (!empty($data['reschedulingDate'])) {
                $patient->setReschedulingDate(\DateTime::createFromFormat('Y-m-d', $data['reschedulingDate']));
            }
    
            // Validar entidad completa antes de persistir
            $errors = $validator->validate($patient);
            if (count($errors) > 0) {
                throw new \RuntimeException('Datos del paciente inválidos');
            }
    
            $entityManager->persist($patient);
            $entityManager->flush();
    
            return $this->json([
                'message' => 'Paciente creado exitosamente',
                'patientId' => $patient->getId()
            ], Response::HTTP_CREATED);
    
        } catch (\InvalidArgumentException $e) {
            $logger->error('Error en formato de fecha', ['error' => $e->getMessage()]);
            return $this->json(['error' => 'Formato de fecha inválido. Use Y-m-d'], Response::HTTP_BAD_REQUEST);
        } catch (\RuntimeException $e) {
            $logger->error('Error de validación', ['error' => $e->getMessage()]);
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            $logger->error('Error al crear paciente', ['error' => $e->getMessage()]);
            return $this->json(['error' => 'Error interno del servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'app_patient_show', methods: ['GET'])]
    public function show(Patient $patient): JsonResponse
    {
        return $this->json([
            'id' => $patient->getId(),
            'documentType' => $patient->getDocumentType(),
            'document' => $patient->getDocument(),
            'firstName' => $patient->getFirstName(),
            'secondName' => $patient->getSecondName(),
            'firstLastName' => $patient->getFirstLastName(),
            'secondLastName' => $patient->getSecondLastName(),
            'birthday' => $patient->getBirthday()->format('Y-m-d'),
            'phone' => $patient->getPhone(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_patient_edit', methods: ['PUT'])]
    public function edit(Request $request, Patient $patient, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $patient->setDocumentType($data['documentType'] ?? $patient->getDocumentType());
        $patient->setDocument($data['document'] ?? $patient->getDocument());
        $patient->setFirstName($data['firstName'] ?? $patient->getFirstName());
        $patient->setSecondName($data['secondName'] ?? $patient->getSecondName());
        $patient->setFirstLastName($data['firstLastName'] ?? $patient->getFirstLastName());
        $patient->setSecondLastName($data['secondLastName'] ?? $patient->getSecondLastName());
        if (isset($data['birthday'])) {
            try {
                $patient->setBirthday(new \DateTime($data['birthday']));
            } catch (\Exception $e) {
                return $this->json(['error' => 'Fecha de nacimiento inválida'], Response::HTTP_BAD_REQUEST);
            }
        }
        $patient->setPhone($data['phone'] ?? $patient->getPhone());
        $patient->setEmail($data['email'] ?? $patient->getEmail());
        $patient->setProcessType($data['processType'] ?? $patient->getProcessType());

        try {
            $patient->setCancellationDate(isset($data['cancellationDate']) ? new \DateTime($data['cancellationDate']) : $patient->getCancellationDate());
            $patient->setReschedulingDate(isset($data['reschedulingDate']) ? new \DateTime($data['reschedulingDate']) : $patient->getReschedulingDate());
        } catch (\Exception $e) {
            return $this->json(['error' => 'Fechas inválidas'], Response::HTTP_BAD_REQUEST);
        }

        $entityManager->flush();

        return $this->json(['message' => 'Paciente actualizado'], Response::HTTP_OK);
    }

    #[Route('/buscar/{document}', name: 'buscar_paciente_por_documento', methods: ['GET'])]
    public function buscarPaciente(string $document, EntityManagerInterface $em): JsonResponse
    {
        $patient = $em->getRepository(Patient::class)->findOneBy(['document' => $document]);
        
        if (!$patient) {
            // Devuelve un objeto vacío en lugar de un error
            return $this->json([]);
        }
        
        return $this->json([
            'documentType' => $patient->getDocumentType(),
            'document' => $patient->getDocument(),
            'firstName' => $patient->getFirstName(),
            'secondName' => $patient->getSecondName(),
            'firstLastName' => $patient->getFirstLastName(),
            'secondLastName' => $patient->getSecondLastName(),
            'birthday' => $patient->getBirthday()->format('Y-m-d'),
            'phone' => $patient->getPhone(),
            'secondPhone' => $patient->getSecondPhone(),
            'department' => $patient->getDepartment(),
            'municipality' => $patient->getMunicipality(),
            'address' => $patient->getAddress(),
            'gender' => $patient->getGender(),
            'bloodGroup' => $patient->getBloodGroup(),
            'rh' => $patient->getRh(),
            'email' => $patient->getEmail(),
        ]);
    }
}
