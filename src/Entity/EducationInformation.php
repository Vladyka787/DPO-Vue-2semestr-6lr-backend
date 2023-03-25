<?php

namespace App\Entity;

use App\Repository\EducationInformationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EducationInformationRepository::class)]
class EducationInformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $educationalInstitution = null;

    #[ORM\Column(length: 255)]
    private ?string $faculty = null;

    #[ORM\Column(length: 255)]
    private ?string $specialization = null;

    #[ORM\Column]
    private ?int $yearOfEnding = null;

    #[ORM\ManyToOne(inversedBy: 'educationInformation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Resume $resume = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEducationalInstitution(): ?string
    {
        return $this->educationalInstitution;
    }

    public function setEducationalInstitution(string $educationalInstitution): self
    {
        $this->educationalInstitution = $educationalInstitution;

        return $this;
    }

    public function getFaculty(): ?string
    {
        return $this->faculty;
    }

    public function setFaculty(string $faculty): self
    {
        $this->faculty = $faculty;

        return $this;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(string $specialization): self
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getYearOfEnding(): ?int
    {
        return $this->yearOfEnding;
    }

    public function setYearOfEnding(int $yearOfEnding): self
    {
        $this->yearOfEnding = $yearOfEnding;

        return $this;
    }

    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    public function setResume(?Resume $resume): self
    {
        $this->resume = $resume;

        return $this;
    }
}
