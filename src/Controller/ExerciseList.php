<?php
namespace App\Controller;


use App\Entity\Exercise;
use App\Entity\Tip;
use App\Form\Type\ExerciseType;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ExerciseList extends AbstractController
{
    #[Route('/exercises',name: 'exercise_list')]
    public function show_exercise_list(ExerciseRepository $exerciseRepository): Response
    {
        $exercises = $exerciseRepository->findAll();
        return $this->render('Exercises\exercise_list.html.twig', ['exercises' => $exercises]);

    }

    #[Route('/exercise/{id}', name: 'individualExercise')]

    public function show_exercise(ExerciseRepository $exerciseRepository, int $id): Response
    {
        $exercise = $exerciseRepository->find($id);

        if (!$exercise) {
            throw $this->createNotFoundException(
                'No exercise found for id' . $id
            );
        }
        return $this->render('Exercises\individual_exercise.html.twig', [
            'exercise' => $exercise
        ]);
    }


    #[Route('/exercise-form',name: 'exercise_form', methods: array('GET', 'POST'))]

    public function exercise_form(Request $request, EntityManagerInterface $entityManager): Response{
        $exercise = new Exercise();
        $form = $this->createForm(ExerciseType::class, $exercise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $exercise = $form->getData();
            $tip = new Tip();
            $tip->setNume("uuas");
            $exercise->setTip($tip);
            $entityManager->persist($exercise); #pregateste codul
            $entityManager->persist($tip);
            $entityManager->flush(); #il ruleaza

        }

        return $this->render('Exercises\addExercisePage.html.twig', ['form' => $form, ]);
    }


}