<?php

namespace App\Controller;

use App\Entity\Workout;
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
            $workout = $form->getData();
            $entityManager->persist($workout);
            $entityManager->flush();
            return $this->render('add_success.html.twig',  ['type' => 'workout']);
        }
        return $this->render('Workouts\addWorkoutPage.html.twig', ['form' => $form, ]);
    }


}