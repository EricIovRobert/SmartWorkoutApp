<?php

namespace App\Controller;

use App\Entity\ExerciseLog;
use App\Form\Type\ExerciseLogType;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    #[Route('/workout/{id}/exercise-log/form',name: 'exercise_log_form', methods: array('GET', 'POST'))]
    public function exerciseLogForm(int $id, Request $request, EntityManagerInterface $entityManager, WorkoutRepository $workoutRepository): Response
    {
        $workout = $workoutRepository->find($id);
        $exerciseLog = new ExerciseLog();
        $exerciseLog->setWorkout($workout);
        $form = $this->createForm(ExerciseLogType::class, $exerciseLog);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $exerciseLog = $form->getData();
            $entityManager->persist($exerciseLog);
            $entityManager->flush();
            return $this->render('ExerciseLog/success.html.twig',  ['workout' => $workout]);
        }
        return $this->render('ExerciseLog\addExerciseLogPage.html.twig', ['form' => $form, 'workout'=>$workout]);

    }
}