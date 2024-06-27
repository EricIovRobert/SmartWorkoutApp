<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
class Workout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nume = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tip $tip_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Data = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

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

    public function getTipId(): ?Tip
    {
        return $this->tip_id;
    }

    public function setTipId(?Tip $tip_id): static
    {
        $this->tip_id = $tip_id;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->Data;
    }

    public function setData(\DateTimeInterface $Data): static
    {
        $this->Data = $Data;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }
}
