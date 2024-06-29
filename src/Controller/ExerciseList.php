<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ExerciseRepository;
class ExerciseList extends AbstractController
{
    #[Route('/exercises',name: 'exercise_list')]
    public function view_objects(ExerciseRepository $exerciseRepository): Response
    {
        $exercises = $exerciseRepository->findAll();
        return $this->render('Exercises\exercise_list.html.twig', ['exercises' => $exercises]);

    }
}