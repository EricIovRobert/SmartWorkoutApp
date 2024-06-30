<?php
namespace App\Controller;


use App\Repository\ExerciseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExerciseList extends AbstractController
{
    #[Route('/exercises',name: 'exercise_list')]
    public function show_exercise_list(ExerciseRepository $exerciseRepository): Response
    {
        $exercises = $exerciseRepository->findAll();
        return $this->render('Exercises\exercise_list.html.twig', ['exercises' => $exercises]);

    }
}