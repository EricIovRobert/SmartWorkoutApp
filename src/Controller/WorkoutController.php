<?php

namespace App\Controller;

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


}