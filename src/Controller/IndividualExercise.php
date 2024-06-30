<?php
namespace App\Controller;

use App\Entity\Exercise;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ExerciseRepository;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;



class IndividualExercise extends AbstractController
{
    #[Route('/exercise/{id}', name: 'individualExercise')]

    public function show_exercise(EntityManagerInterface $entityManager, int $id): Response
    {
        $exercise = $entityManager->getRepository(Exercise::class)->find($id);

        if (!$exercise) {
            throw $this->createNotFoundException(
                'No exercise found for id' . $id
            );
        }
        return $this->render('Exercises\individual_exercise.html.twig', [
            'exercise' => $exercise
        ]);
    }
}