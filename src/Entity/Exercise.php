<?php

namespace App\Entity;

use App\Repository\ExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
class Exercise
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
        maxMessage: "Name should be maximum {{ limit }} characters long"
    )]
    #[ORM\Column(length: 255)]
    private ?string $Name = null;


    #[Assert\NotBlank(message: "Video link cannot be blank")]
    #[Assert\Length(
        min: 28,
        max: 2048,
        minMessage: "Video link should be at least {{ limit }} characters long",
        maxMessage: "Video link should be maximum {{ limit }} characters long"
    )]
    #[Assert\Regex(
        pattern: "/\b((http(s)?:\/\/)?(www\.)?youtube\.com\/(watch\?v=|embed\/|v\/|.*&v=)|youtu\.be\/)([\w\-]{10,12})(\&.*)?\b/",
        message: "Video link should be a valid YouTube URL"
    )]
    #[ORM\Column(length: 2048)]
    private ?string $link_video = null;

    #[ORM\ManyToOne(inversedBy: 'exercises')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tip $tip = null;

    /**
     * @var Collection<int, ExerciseLog>
     */
    #[ORM\OneToMany(targetEntity: ExerciseLog::class, mappedBy: 'exercise', orphanRemoval: true)]
    private Collection $exerciseLogs;

    #[Assert\NotBlank(message: "Description cannot be blank")]
    #[Assert\Length(
        min: 5,
        max: 500,
        minMessage: "Description should be at least {{ limit }} characters long",
        maxMessage: "Description should be maximum {{ limit }} characters long"
    )]
    #[ORM\Column(length: 500)]
    private ?string $Description = null;

    public function __construct()
    {
        $this->exerciseLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

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

    public function getTip(): ?Tip
    {
        return $this->tip;
    }

    public function setTip(?Tip $tip): static
    {
        $this->tip = $tip;

        return $this;
    }

    /**
     * @return Collection<int, ExerciseLog>
     */
    public function getExerciseLogs(): Collection
    {
        return $this->exerciseLogs;
    }

    public function addExerciseLog(ExerciseLog $exerciseLog): static
    {
        if (!$this->exerciseLogs->contains($exerciseLog)) {
            $this->exerciseLogs->add($exerciseLog);
            $exerciseLog->setExercise($this);
        }

        return $this;
    }

    public function removeExerciseLog(ExerciseLog $exerciseLog): static
    {
        if ($this->exerciseLogs->removeElement($exerciseLog)) {
            if ($exerciseLog->getExercise() === $this) {
                $exerciseLog->setExercise(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }
}
