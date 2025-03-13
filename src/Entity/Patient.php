<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'patients')]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'document_type', type: 'string', length: 50)]
    private string $documentType;

    #[ORM\Column(name: 'document', type: 'string', length: 50, unique: true)]
    private string $document;

    #[ORM\Column(name: 'first_name', type: 'string', length: 100)]
    private string $firstName;

    #[ORM\Column(name: 'second_name', type: 'string', length: 100, nullable: true)]
    private ?string $secondName = null;

    #[ORM\Column(name: 'first_last_name', type: 'string', length: 100)]
    private string $firstLastName;

    #[ORM\Column(name: 'second_last_name', type: 'string', length: 100, nullable: true)]
    private ?string $secondLastName = null;

    #[ORM\Column(name: 'birthday', type: 'datetime')]
    private \DateTimeInterface $birthday;

    #[ORM\Column(name: 'phone', type: 'string', length: 20)]
    private string $phone;

    #[ORM\Column(name: 'second_phone', type: 'string', length: 20, nullable: true)]
    private ?string $secondPhone = null;

    #[ORM\Column(name: 'department', type: 'string', length: 100)]
    private string $department;

    #[ORM\Column(name: 'municipality', type: 'string', length: 100, nullable: true)]
    private ?string $municipality = null;

    #[ORM\Column(name: 'address', type: 'text')]
    private string $address;

    #[ORM\Column(name: 'specialty', type: 'string', length: 100)]
    private string $specialty;

    #[ORM\Column(name: 'custom_health_entity', type: 'text', length: 100)]
    private string $customHealthEntity;

    #[ORM\Column(name: 'email', type: 'string', length: 255, unique: true)]
    private string $email;

    #[ORM\Column(name: 'gender', type: 'string', length: 10)]
    private string $gender;

    #[ORM\Column(name: 'blood_group', type: 'string', length: 10)]
    private string $bloodGroup;

    #[ORM\Column(name: 'rh', type: 'string', length: 10)]
    private string $rh;

    #[ORM\Column(name: 'process_type', type: 'string', length: 50)]
    private string $processType;

    #[ORM\Column(name: 'entity_health', type: 'string', length: 100)]
    private string $entityHealth;

    #[ORM\Column(name: 'regime', type: 'string', length: 50)]
    private string $regime;

    #[ORM\Column(name: 'appointment_type', type: 'string', length: 50)]
    private string $appointmentType;

    #[ORM\Column(name: 'service', type: 'string', length: 100)]
    private string $service;

    #[ORM\Column(name: 'authorization_number', type: 'string', length: 50, nullable: true)]
    private ?string $authorizationNumber = null;

    #[ORM\Column(name: 'image_path', type: 'string', length: 255, nullable: true)]
    private ?string $imagePath = null;

    #[ORM\Column(name: 'path_image_eps', type: 'string', length: 255, nullable: true)]
    private ?string $pathImageEPS = null;

    #[ORM\Column(name: 'cancellation_date', type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $cancellationDate = null;

    #[ORM\Column(name: 'rescheduling_date', type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $reschedulingDate = null;

    // Méodos Getter y Setter...



    // Getters y Setters
    public function getId(): int { return $this->id; }
    public function getDocumentType(): string { return $this->documentType; }
    public function setDocumentType(string $documentType): void { $this->documentType = $documentType; }
    public function getDocument(): string { return $this->document; }
    public function setDocument(string $document): void { $this->document = $document; }
    public function getFirstName(): string { return $this->firstName; }
    public function setFirstName(string $firstName): void { $this->firstName = $firstName; }
    public function getSecondName(): ?string { return $this->secondName; }
    public function setSecondName(?string $secondName): void { $this->secondName = $secondName; }
    public function getFirstLastName(): string { return $this->firstLastName; }
    public function setFirstLastName(string $firstLastName): void { $this->firstLastName = $firstLastName; }
    public function getSecondLastName(): ?string { return $this->secondLastName; }
    public function setSecondLastName(?string $secondLastName): void { $this->secondLastName = $secondLastName; }
    public function getBirthday(): \DateTimeInterface { return $this->birthday; }
    public function setBirthday(\DateTimeInterface $birthday): void { $this->birthday = $birthday; }
    public function getPhone(): string { return $this->phone; }
    public function setPhone(string $phone): void { $this->phone = $phone; }
    public function getSecondPhone(): ?string { return $this->secondPhone; }
    public function setSecondPhone(?string $secondPhone): void { $this->secondPhone = $secondPhone; }
    public function getDepartment(): string { return $this->department; }
    public function setDepartment(string $department): void { $this->department = $department; }
    public function getMunicipality(): ?string { return $this->municipality; }
    public function setMunicipality(?string $municipality): void { $this->municipality = $municipality; }
    public function getAddress(): string { return $this->address; }
    public function setAddress(string $address): void { $this->address = $address; }
    public function getSpecialty(): string { return $this->specialty; }
    public function setSpecialty(string $specialty): void { $this->specialty = $specialty; }
    public function getCustomHealthEntity(): string { return $this->customHealthEntity; }
    public function setCustomHealthEntity(string $customHealthEntity): void { $this->customHealthEntity = $customHealthEntity; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function getGender(): string { return $this->gender; }
    public function setGender(string $gender): void { $this->gender = $gender; }
    public function getBloodGroup(): string { return $this->bloodGroup; }
    public function setBloodGroup(string $bloodGroup): void { $this->bloodGroup = $bloodGroup; }
    public function getRh(): string { return $this->rh; }
    public function setRh(string $rh): void { $this->rh = $rh; }
    public function getProcessType(): string { return $this->processType; }
    public function setProcessType(string $processType): void { $this->processType = $processType; }
    public function getEntityHealth(): string { return $this->entityHealth; }
    public function setEntityHealth(string $entityHealth): void { $this->entityHealth = $entityHealth; }
    public function getRegime(): string { return $this->regime; }
    public function setRegime(string $regime): void { $this->regime = $regime; }
    public function getAppointmentType(): string { return $this->appointmentType; }
    public function setAppointmentType(string $appointmentType): void { $this->appointmentType = $appointmentType; }
    public function getService(): string { return $this->service; }
    public function setService(string $service): void { $this->service = $service; }
    public function getAuthorizationNumber(): ?string { return $this->authorizationNumber; }
    public function setAuthorizationNumber(?string $authorizationNumber): void { $this->authorizationNumber = $authorizationNumber; }
    public function getImagePath(): ?string { return $this->imagePath; }
    public function setImagePath(?string $imagePath): void { $this->imagePath = $imagePath; }
    public function getPathImageEPS(): ?string { return $this->pathImageEPS; }
    public function setPathImageEPS(?string $pathImageEPS): void { $this->pathImageEPS = $pathImageEPS; }
    public function getCancellationDate(): ?\DateTimeInterface { return $this->cancellationDate; }
    public function setCancellationDate(?\DateTimeInterface $cancellationDate): void { $this->cancellationDate = $cancellationDate; }
    public function getReschedulingDate(): ?\DateTimeInterface { return $this->reschedulingDate; }
    public function setReschedulingDate(?\DateTimeInterface $reschedulingDate): void { $this->reschedulingDate = $reschedulingDate; }
}