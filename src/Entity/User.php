<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Laborantin::class)]
    private Collection $specialisation;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Secretaire::class)]
    private Collection $secretaires;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: RendezVous::class)]
    private Collection $rv;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Resultat::class)]
    private Collection $resultats;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Patient::class)]
    private Collection $user;

    public function __construct()
    {
        $this->specialisation = new ArrayCollection();
        $this->secretaires = new ArrayCollection();
        $this->rv = new ArrayCollection();
        $this->resultats = new ArrayCollection();
        $this->user = new ArrayCollection();
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
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
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return Collection<int, Laborantin>
     */
    public function getSpecialisation(): Collection
    {
        return $this->specialisation;
    }

    public function addSpecialisation(Laborantin $specialisation): static
    {
        if (!$this->specialisation->contains($specialisation)) {
            $this->specialisation->add($specialisation);
            $specialisation->setUserId($this);
        }

        return $this;
    }

    public function removeSpecialisation(Laborantin $specialisation): static
    {
        if ($this->specialisation->removeElement($specialisation)) {
            // set the owning side to null (unless already changed)
            if ($specialisation->getUserId() === $this) {
                $specialisation->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Secretaire>
     */
    public function getSecretaires(): Collection
    {
        return $this->secretaires;
    }

    public function addSecretaire(Secretaire $secretaire): static
    {
        if (!$this->secretaires->contains($secretaire)) {
            $this->secretaires->add($secretaire);
            $secretaire->setUser($this);
        }

        return $this;
    }

    public function removeSecretaire(Secretaire $secretaire): static
    {
        if ($this->secretaires->removeElement($secretaire)) {
            // set the owning side to null (unless already changed)
            if ($secretaire->getUser() === $this) {
                $secretaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRv(): Collection
    {
        return $this->rv;
    }

    public function addRv(RendezVous $rv): static
    {
        if (!$this->rv->contains($rv)) {
            $this->rv->add($rv);
            $rv->setPatient($this);
        }

        return $this;
    }

    public function removeRv(RendezVous $rv): static
    {
        if ($this->rv->removeElement($rv)) {
            // set the owning side to null (unless already changed)
            if ($rv->getPatient() === $this) {
                $rv->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Resultat>
     */
    public function getResultats(): Collection
    {
        return $this->resultats;
    }

    public function addResultat(Resultat $resultat): static
    {
        if (!$this->resultats->contains($resultat)) {
            $this->resultats->add($resultat);
            $resultat->setPatient($this);
        }

        return $this;
    }

    public function removeResultat(Resultat $resultat): static
    {
        if ($this->resultats->removeElement($resultat)) {
            // set the owning side to null (unless already changed)
            if ($resultat->getPatient() === $this) {
                $resultat->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Patient>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Patient $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setUserId($this);
        }

        return $this;
    }

    public function removeUser(Patient $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getUserId() === $this) {
                $user->setUserId(null);
            }
        }

        return $this;
    }


        public function __toString():string
        {
            return $this->getUsername() ?? '';

        }

    }