<?php

namespace App\Controller;

use App\Entity\ExerciseLog;
use App\Form\Type\DeleteButtonType;
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

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $exerciseLog = $form->getData();
                $entityManager->persist($exerciseLog);
                $entityManager->flush();

                return $this->render('ExerciseLog/success.html.twig',  ['workout' => $workout]);
        }
// else {
//                dd($form);
//            }

        }
        return $this->render('ExerciseLog\addExerciseLogPage.html.twig', ['form' => $form, 'workout'=>$workout]);

    }
    #[Route('/workout/{id}/exercise-log/{id2}/edit-form',name: 'show_exercise_log_edit', methods: ['GET'])]
    public function showExerciseLogForm(Request $request, ExerciseLogRepository $exerciseLogRepository, WorkoutRepository $workoutRepository, int $id, EntityManagerInterface $entityManager, int $id2): Response
    {
        $exerciseLog = $exerciseLogRepository->find($id2);
        $form = $this->createForm(ExerciseLogType::class, $exerciseLog, ['action' => $this->generateUrl('exercise_log_edit', ['id' => $id, 'id2' => $id2]), 'method' => 'PUT']);
        $form->handleRequest($request);
        return $this->render('ExerciseLog/editExerciseLog.html.twig', ['form' => $form, 'ex'=>$exerciseLog]);
    }

    #[Route('/workout/{id}/exercise-log/{id2}',name: 'exercise_log_edit', methods: ['PUT'])]
    public function edit(Request $request, ExerciseLogRepository $exerciseLogRepository, WorkoutRepository $workoutRepository, int $id, EntityManagerInterface $entityManager, int $id2): Response
    {
        $exerciseLog = $exerciseLogRepository->find($id2);
        $form = $this->createForm(ExerciseLogType::class, $exerciseLog, ['action' => $this->generateUrl('exercise_log_edit', ['id' => $id, 'id2' => $id2]), 'method' => 'PUT']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $exerciseLog = $form->getData();
            $workout = $workoutRepository->find($id);
            $exerciseLog->setWorkout($workout);
            $entityManager->persist($exerciseLog);
            $entityManager->flush();
            return $this->render('ExerciseLog/operation_success.html.twig', ['ex' => $exerciseLog, 'type'=>'edited']);
        }
        return $this->render('ExerciseLog/editExerciseLog.html.twig', ['form' => $form, 'ex'=>$exerciseLog], );
    }

    #[Route('/workout/{id}/exercise-log/{id2}/delete-form', name: 'show_exercise_log_delete', methods: ['GET'])]
    public function showDeleteForm(Request $request, int $id, ExerciseLogRepository $exerciseLogRepository, EntityManagerInterface $entityManager, int $id2): Response
    {
        $form = $this->createForm(DeleteButtonType::class, null, ['action' => $this->generateUrl('exercise_log_delete', ['id' => $id, 'id2' => $id2]), 'method' => 'DELETE']);
        $form->handleRequest($request);
        return $this->render('deleteConfirmation.html.twig', ['form' => $form, 'type' => 'exercise log', ]);

    }

    #[Route('/workout/{id}/exercise-log/{id2}', name: 'exercise_log_delete', methods: ['DELETE'])]
    public function delete(Request $request, int $id, ExerciseLogRepository $exerciseLogRepository, EntityManagerInterface $entityManager, int $id2): Response
    {
        $exerciseLog = $exerciseLogRepository->find($id2);
        $form = $this->createForm(DeleteButtonType::class, null, ['action' => $this->generateUrl('exercise_log_delete', ['id' => $id, 'id2' => $id2]), 'method' => 'DELETE']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($exerciseLog);
            $entityManager->flush();
            return $this->render('ExerciseLog/operation_success.html.twig', ['ex' => $exerciseLog, 'type'=>'deleted']);
        }
        return $this->render('deleteConfirmation.html.twig', ['form' => $form, 'type' => 'exercise log']);

    }

}