<?php

namespace App\Entity;

use App\Repository\ResultatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatRepository::class)]
class Resultat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $resultat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateResultat = null;

    #[ORM\ManyToOne(inversedBy: 'resultats')]
    private ?User $patient = null;

    #[ORM\ManyToOne(inversedBy: 'resultats')]
    private ?Analyses $analyse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function setResultat(string $resultat): static
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getDateResultat(): ?\DateTimeInterface
    {
        return $this->dateResultat;
    }

    public function setDateResultat(\DateTimeInterface $dateResultat): static
    {
        $this->dateResultat = $dateResultat;

        return $this;
    }

    public function getPatient(): ?User
    {
        return $this->patient;
    }

    public function setPatient(?User $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getAnalyse(): ?Analyses
    {
        return $this->analyse;
    }

    public function setAnalyse(?Analyses $analyse): static
    {
        $this->analyse = $analyse;

        return $this;
    }
}
