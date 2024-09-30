<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $race = null;

    #[ORM\Column]
    private array $images = [];

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Habitats $habitat = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(targetEntity: ReportDeSante::class, mappedBy: 'animal')]
    private Collection $reportDeSantes;

    public function __construct()
    {
        $this->reportDeSantes = new ArrayCollection();
    }

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

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getHabitatId(): ?Habitats
    {
        return $this->habitat;
    }

    public function setHabitatId(?Habitats $habitat): static
    {
        $this->habitat = $habitat;

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

    /**
     * @return Collection<int, ReportDeSante>
     */
    public function getReportDeSantes(): Collection
    {
        return $this->reportDeSantes;
    }

    public function addReportDeSante(ReportDeSante $reportDeSante): static
    {
        if (!$this->reportDeSantes->contains($reportDeSante)) {
            $this->reportDeSantes->add($reportDeSante);
            $reportDeSante->setAnimal($this);
        }

        return $this;
    }

    public function removeReportDeSante(ReportDeSante $reportDeSante): static
    {
        if ($this->reportDeSantes->removeElement($reportDeSante)) {
            // set the owning side to null (unless already changed)
            if ($reportDeSante->getAnimal() === $this) {
                $reportDeSante->setAnimal(null);
            }
        }

        return $this;
    }
}
