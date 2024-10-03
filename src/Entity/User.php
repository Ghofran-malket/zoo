<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: ReportDeSante::class, mappedBy: 'veterinaire')]
    private Collection $reportDeSantes;

    public function __construct()
    {
        $this->reportDeSantes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    public function getUserIdentifier(): string
    {
        return $this->email; // Retourne l'identifiant unique de l'utilisateur, souvent l'email

    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        // Si vous utilisez bcrypt, vous n'avez pas besoin d'un salt supplémentaire
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // Si vous stockez des données temporaires sensibles sur l'utilisateur, effacez-les ici
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
            $reportDeSante->setVeterinaire($this);
        }

        return $this;
    }

    public function removeReportDeSante(ReportDeSante $reportDeSante): static
    {
        if ($this->reportDeSantes->removeElement($reportDeSante)) {
            // set the owning side to null (unless already changed)
            if ($reportDeSante->getVeterinaire() === $this) {
                $reportDeSante->setVeterinaire(null);
            }
        }

        return $this;
    }
}
