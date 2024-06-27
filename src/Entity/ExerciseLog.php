<?php

namespace App\Entity;

use App\Repository\ExerciseLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseLogRepository::class)]
class ExerciseLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Workout $workout_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exercitii $exercise_id = null;

    #[ORM\Column]
    private ?int $nr_reps = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $Durata = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkoutId(): ?Workout
    {
        return $this->workout_id;
    }

    public function setWorkoutId(?Workout $workout_id): static
    {
        $this->workout_id = $workout_id;

        return $this;
    }

    public function getExerciseId(): ?Exercitii
    {
        return $this->exercise_id;
    }

    public function setExerciseId(?Exercitii $exercise_id): static
    {
        $this->exercise_id = $exercise_id;

        return $this;
    }

    public function getNrReps(): ?int
    {
        return $this->nr_reps;
    }

    public function setNrReps(int $nr_reps): static
    {
        $this->nr_reps = $nr_reps;

        return $this;
    }

    public function getDurata(): ?\DateTimeInterface
    {
        return $this->Durata;
    }

    public function setDurata(\DateTimeInterface $Durata): static
    {
        $this->Durata = $Durata;

        return $this;
    }
}
