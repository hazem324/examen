<?php

namespace App\Entity;

use App\Repository\CabinetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CabinetRepository::class)]
class Cabinet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $nbrPatient = null;

    #[ORM\ManyToOne(inversedBy: 'cabinets')]
    private ?Patient $patients = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getNbrPatient(): ?int
    {
        return $this->nbrPatient;
    }

    public function setNbrPatient(int $nbrPatient): static
    {
        $this->nbrPatient = $nbrPatient;

        return $this;
    }

    public function getPatients(): ?Patient
    {
        return $this->patients;
    }

    public function setPatients(?Patient $patients): static
    {
        $this->patients = $patients;

        return $this;
    }
}
