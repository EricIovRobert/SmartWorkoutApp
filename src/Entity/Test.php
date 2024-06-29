<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $TESt2 = null;

    #[ORM\Column(length: 255)]
    private ?string $ceva = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getTESt2(): ?string
    {
        return $this->TESt2;
    }

    public function setTESt2(string $TESt2): static
    {
        $this->TESt2 = $TESt2;

        return $this;
    }

    public function getCeva(): ?string
    {
        return $this->ceva;
    }

    public function setCeva(string $ceva): static
    {
        $this->ceva = $ceva;

        return $this;
    }
}
