<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Name cannot be blank")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: "Name should be at least {{ limit }} characters long",
        maxMessage: "Name should be maximum length {{ limit }} characters long"
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z]+(?: [a-zA-Z]+)*$/",
        message: "Name should only contain alphabetic characters and spaces"
    )]
    #[ORM\Column(length: 255)]
    private ?string $Nume = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];
    #[Assert\NotBlank(message: "Email cannot be blank")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Email should be maximum {{ limit }} characters long"
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",
        message: "Email should be a valid email address"
    )]
    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[Assert\NotBlank(message: "Password cannot be blank")]
    #[Assert\Length(
        min: 8,
        max: 255,
        minMessage: "Password should be at least {{ limit }} characters long",
        maxMessage: "Password should be maximum {{ limit }} characters long"
    )]
    #[Assert\Regex(
        pattern: "/^(?=.*[0-9])(?=.*[!@#$%?^&*])[A-Za-z0-9!@#$%?^&*]{8,}$/",
        message: "Password should contain at least one number and one special character ($, #, @, !, *, &, ?, %, ^)"
    )]
    #[ORM\Column(length: 255)]
    private ?string $Parola = null;

    #[Assert\NotBlank(message: "Birthday cannot be blank")]
    #[ORM\Column(length: 255)]
    private ?\DateTime $Birthday = null;

    #[Assert\NotNull(message: "Gender cannot be null")]
    #[Assert\Choice(
        choices: [0, 1, 2]
    )]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $Gender = null;

    /**
     * @var Collection<int, Workout>
     */
    #[ORM\OneToMany(targetEntity: Workout::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $workouts;

    public function __construct()
    {
        $this->workouts = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNume(): ?string
    {
        return $this->Nume;
    }

    public function setNume(string $Nume): static
    {
        $this->Nume = $Nume;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getParola(): ?string
    {
        return $this->Parola;
    }

    public function setParola(string $Parola): static
    {
        $this->Parola = $Parola;

        return $this;
    }

    public function getBirthday():?\DateTime
    {
        return $this->Birthday;
    }

    public function setBirthday(\DateTime $Birthday): static
    {
        $this->Birthday = $Birthday;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->Gender;
    }

    public function setGender(string $Gender): static
    {
        $this->Gender = $Gender;

        return $this;
    }

    /**
     * @return Collection<int, Workout>
     */
    public function getWorkouts(): Collection
    {
        return $this->workouts;
    }

    public function addWorkout(Workout $workout): static
    {
        if (!$this->workouts->contains($workout)) {
            $this->workouts->add($workout);
            $workout->setUser($this);
        }

        return $this;
    }

    public function removeWorkout(Workout $workout): static
    {
        if ($this->workouts->removeElement($workout)) {
            // set the owning side to null (unless already changed)
            if ($workout->getUser() === $this) {
                $workout->setUser(null);
            }
        }

        return $this;
    }
    public function getUserIdentifier(): string
    {
        return (string) $this->mail;
    }
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function getPassword(): ?string
    {
        return $this->Parola;
    }

}
