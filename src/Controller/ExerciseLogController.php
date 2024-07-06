<?php

namespace App\Controller;

use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ExerciseLogRepository;

class ExerciseLogController extends AbstractController
{
    #[Route('/workout/{id}/exercise-log', name: 'exercise_log_list')]
    public function showExerciseLogs(int $id, ExerciseLogRepository $exerciseLogRepository, WorkoutRepository $workoutRepository): Response
    {
        $workout = $workoutRepository->find($id);
        $exerciseLogs = $exerciseLogRepository->findBy(['workout' => $workout]);
        return $this->render('ExerciseLog/exerciseLog_list.html.twig', [
            'workout' => $workout,
            'exerciseLogs' => $exerciseLogs,
        ]);
    }
}