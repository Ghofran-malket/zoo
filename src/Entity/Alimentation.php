<?php

namespace App\Entity;

use App\Repository\AlimentationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlimentationRepository::class)]
class Alimentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTIFY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $foodType = null;

    #[ORM\Column(length: 255)]
    private ?string $quantity = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $feedingTime = null;

    #[ORM\ManyToOne(inversedBy: 'alimentations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'alimentations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $employee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoodType(): ?string
    {
        return $this->foodType;
    }

    public function setFoodType(string $foodType): static
    {
        $this->foodType = $foodType;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getFeedingTime(): ?\DateTimeInterface
    {
        return $this->feedingTime;
    }

    public function setFeedingTime(\DateTimeInterface $feedingTime): static
    {
        $this->feedingTime = $feedingTime;

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

    public function getEmployee(): ?User
    {
        return $this->employee;
    }

    public function setEmployee(?User $employee): static
    {
        $this->employee = $employee;

        return $this;
    }
}
