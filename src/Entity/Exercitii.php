<?php

namespace App\Entity;

use App\Repository\ExercitiiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExercitiiRepository::class)]
class Exercitii
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nume = null;

    #[ORM\Column(length: 255)]
    private ?string $link_video = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tip $tip_id = null;

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

    public function getLinkVideo(): ?string
    {
        return $this->link_video;
    }

    public function setLinkVideo(string $link_video): static
    {
        $this->link_video = $link_video;

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
}
