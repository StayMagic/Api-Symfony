<?php

namespace App\Controller;

use App\Entity\Patient;
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
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validación de los datos
        $constraint = new Assert\Collection([
            'documentType' => new Assert\NotBlank(),
            'document' => [new Assert\NotBlank(), new Assert\Type('string')],
            'firstName' => new Assert\NotBlank(),
            'firstLastName' => new Assert\NotBlank(),
            'birthday' => new Assert\NotBlank(),
            'phone' => new Assert\NotBlank(),
            'email' => [new Assert\NotBlank(), new Assert\Email()],
            // agregar otros campos que desees validar
        ]);

        $violations = $validator->validate($data, $constraint);

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[] = $violation->getMessage();
            }
            return $this->json(['error' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $patient = new Patient();
        $patient->setDocumentType($data['documentType']);
        $patient->setDocument($data['document']);
        $patient->setFirstName($data['firstName']);
        $patient->setSecondName($data['secondName'] ?? null);
        $patient->setFirstLastName($data['firstLastName']);
        $patient->setSecondLastName($data['secondLastName'] ?? null);
        try {
            $patient->setBirthday(new \DateTime($data['birthday']));
        } catch (\Exception $e) {
            return $this->json(['error' => 'Fecha de nacimiento inválida'], Response::HTTP_BAD_REQUEST);
        }
        $patient->setPhone($data['phone']);
        $patient->setSecondPhone($data['secondPhone'] ?? null);
        $patient->setDepartment($data['department']);
        $patient->setMunicipality($data['municipality']);
        $patient->setAddress($data['address']);
        $patient->setEmail($data['email']);
        $patient->setGender($data['gender']);
        $patient->setBloodGroup($data['bloodGroup']);
        $patient->setRh($data['rh']);
        $patient->setProcessType($data['processType']);
        $patient->setEntityHealth($data['entityHealth']);
        $patient->setRegime($data['regime']);
        $patient->setAppointmentType($data['appointmentType']);
        $patient->setService($data['service']);
        $patient->setAuthorizationNumber($data['authorizationNumber'] ?? null);
        $patient->setImagePath($data['imagePath'] ?? null);
        $patient->setPathImageEPS($data['pathImageEPS'] ?? null);
        $patient->setSpecialty($data['specialty'] ?? null);
        $patient->setCustomHealthEntity($data['customHealthEntity'] ?? null);

        try {
            $patient->setCancellationDate(!empty($data['cancellationDate']) ? new \DateTime($data['cancellationDate']) : null);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Fecha de cancelación inválida'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $patient->setReschedulingDate(!empty($data['reschedulingDate']) ? new \DateTime($data['reschedulingDate']) : null);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Fecha de reprogramación inválida'], Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($patient);
        $entityManager->flush();

        return $this->json(['message' => 'Paciente creado'], Response::HTTP_CREATED);
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
            return $this->json(['error' => 'Paciente no encontrado'], Response::HTTP_NOT_FOUND);
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
