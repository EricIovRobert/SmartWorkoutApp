<?php

namespace App\Controller;

use App\Entity\Workout;
use App\Form\Type\DeleteButtonType;
use App\Form\Type\WorkoutType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\WorkoutRepository;

class WorkoutController extends AbstractController{

    #[Route('/workouts', name: 'workout_list')]
    public function show_workout_list(WorkoutRepository $workoutRepository,Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $offset = ($page - 1) * $limit;

        $totalWorkouts = $workoutRepository->count([]);
        $workouts = $workoutRepository->findBy([], null, $limit, $offset);

        return $this->render('Workouts/workout_list.html.twig', [
            'workouts' => $workouts,
            'currentPage' => $page,
            'totalPages' => ceil($totalWorkouts / $limit)
        ]);

    }

    #[Route('/workout-form',name: 'workout_form', methods: array('GET','POST'))]
    public function workout_form(Request $request, EntityManagerInterface $entityManager): Response
    {
        $workout = new Workout();
        $form = $this->createForm(WorkoutType::class, $workout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workout->setDate(new \DateTime());
            $workout = $form->getData();
            $entityManager->persist($workout);
            $entityManager->flush();
            return $this->render('add_success.html.twig',  ['type' => 'workout']);
        }
        return $this->render('Workouts\addWorkoutPage.html.twig', ['form' => $form, ]);
    }
    #[Route('/workout/{id}/delete-form', name: 'show_workout_delete', methods: ['GET'])]
    public function showDeleteForm(Request $request, int $id, WorkoutRepository $workoutRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DeleteButtonType::class, null, [
            'action' => $this->generateUrl('workout_delete', ['id' => $id]),
            'method' => 'DELETE',
        ]);
        $form->handleRequest($request);
        return $this->render('deleteConfirmation.html.twig', ['form' => $form, 'type' => 'workout']);

    }

    #[Route('/workout/{id}', name: 'workout_delete', methods: ['DELETE'])]
    public function delete(Request $request, int $id, WorkoutRepository $workoutRepository, EntityManagerInterface $entityManager): Response
    {
        $workout = $workoutRepository->find($id);
        $form = $this->createForm(DeleteButtonType::class, null, [
            'action' => $this->generateUrl('workout_delete', ['id' => $id]),
            'method' => 'DELETE',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($workout);
            $entityManager->flush();
            return $this->render('delete_success.html.twig', ['type' => 'workout']);

        }
        return $this->render('deleteConfirmation.html.twig', ['form' => $form, 'type' => 'workout']);

    }

    #[Route('/workout/{id}/edit-form', name: 'show_workout_edit', methods: ['GET'])]
    public function showEditForm(Request $request, WorkoutRepository $workoutRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $workout = $workoutRepository->find($id);
        $form = $this->createForm(WorkoutType::class, $workout, ['action' => $this->generateUrl('workout_edit', ['id' => $id]),
            'method' => 'PUT']);
        $form->handleRequest($request);
        return $this->render('Workouts\edit-workout.html.twig', ['form'=> $form]);
    }

    #[Route('/workout/{id}/', name: 'workout_edit', methods: ['PUT'])]
    public function edit(Request $request, WorkoutRepository $workoutRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $workout = $workoutRepository->find($id);
        $form = $this->createForm(WorkoutType::class, $workout, ['action' => $this->generateUrl('workout_edit', ['id' => $id]),
            'method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workout = $form->getData();
            $entityManager->persist($workout);
            $entityManager->flush();
            return $this->render('operation_success.html.twig', ['type' => 'workout']);

        }
        return $this->render('Workouts\edit-workout.html.twig', ['form'=> $form]);
    }







}