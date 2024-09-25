<?php

namespace App\Entity;

use App\Repository\ZooRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZooRepository::class)]
class Zoo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $location = null;

    #[ORM\Column(length: 100)]
    private ?string $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 100)]
    private ?string $opening_time = null;

    #[ORM\Column(length: 100)]
    private ?string $phone_number = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $facebook_link = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $twitter_link = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $tiktok_link = null;

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

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

    public function getOpeningTime(): ?string
    {
        return $this->opening_time;
    }

    public function setOpeningTime(string $opening_time): static
    {
        $this->opening_time = $opening_time;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getFacebookLink(): ?string
    {
        return $this->facebook_link;
    }

    public function setFacebookLink(?string $facebook_link): static
    {
        $this->facebook_link = $facebook_link;

        return $this;
    }

    public function getTwitterLink(): ?string
    {
        return $this->twitter_link;
    }

    public function setTwitterLink(?string $twitter_link): static
    {
        $this->twitter_link = $twitter_link;

        return $this;
    }

    public function getTiktokLink(): ?string
    {
        return $this->tiktok_link;
    }

    public function setTiktokLink(?string $tiktok_link): static
    {
        $this->tiktok_link = $tiktok_link;

        return $this;
    }
}
