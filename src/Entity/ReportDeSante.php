<?php

namespace App\Entity;

use App\Repository\ReportDeSanteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportDeSanteRepository::class)]
class ReportDeSante
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTIFY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\Column(length: 255)]
    private ?string $food = null;

    #[ORM\Column(length: 255)]
    private ?string $food_weight = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $additional_info = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'reportDeSantes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'reportDeSantes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $veterinaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getFood(): ?string
    {
        return $this->food;
    }

    public function setFood(string $food): static
    {
        $this->food = $food;

        return $this;
    }

    public function getFoodWeight(): ?string
    {
        return $this->food_weight;
    }

    public function setFoodWeight(string $food_weight): static
    {
        $this->food_weight = $food_weight;

        return $this;
    }


    public function getAdditionalInfo(): ?string
    {
        return $this->additional_info;
    }

    public function setAdditionalInfo(string $additional_info): static
    {
        $this->additional_info = $additional_info;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getVeterinaire(): ?User
    {
        return $this->veterinaire;
    }

    public function setVeterinaire(?User $veterinaire): static
    {
        $this->veterinaire = $veterinaire;

        return $this;
    }
}
