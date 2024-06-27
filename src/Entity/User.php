<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nume = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $Parola = null;

    #[ORM\Column(length: 255)]
    private ?string $Birthday = null;

    #[ORM\Column(length: 255)]
    private ?string $Gender = null;

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

    public function getBirthday(): ?string
    {
        return $this->Birthday;
    }

    public function setBirthday(string $Birthday): static
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
}
