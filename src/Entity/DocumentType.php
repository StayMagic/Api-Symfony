<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "document_types")] // Aseguramos que la entidad usa la tabla correcta
class TipoDocumento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $label;

    #[ORM\Column(type: "string", length: 255)]
    private string $value;

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    // Setters
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }
}

