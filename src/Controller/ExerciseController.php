<?php
namespace App\Controller;


use App\Entity\Exercise;
use App\Form\Type\DeleteButtonType;
use App\Form\Type\ExerciseType;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ExerciseController extends AbstractController
{
    #[Route('/exercises', name: 'exercise_list')]
    public function show_exercise_list(Request $request, ExerciseRepository $exerciseRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $offset = ($page - 1) * $limit;

        $totalExercises = $exerciseRepository->count([]);
        $exercises = $exerciseRepository->findBy([], null, $limit, $offset);

        return $this->render('Exercises/exercise_list.html.twig', [
            'exercises' => $exercises,
            'currentPage' => $page,
            'totalPages' => ceil($totalExercises / $limit)
        ]);
    }

    #[Route('/exercise/{id}', name: 'individualExercise', methods: ["GET"])]

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
            $entityManager->persist($exercise); #pregateste codul
            $entityManager->flush(); #il ruleaza
            return $this->render('add_success.html.twig',  ['type' => 'exercise']);

        }
        return $this->render('Exercises\addExercisePage.html.twig', ['form' => $form, ]);
    }

    #[Route('/exercise/{id}/edit-form',name: 'show_exercise_edit', methods: ['GET'])]
    public function showEditForm(Request $request, ExerciseRepository $exerciseRepository,EntityManagerInterface $entityManager, int $id): Response
    {
        $exercise = $exerciseRepository->find($id);
        $form = $this->createForm(ExerciseType::class, $exercise, ['action' => $this->generateUrl('exercise_edit', ['id' => $id]),
            'method' => 'PUT']);
        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
//            $exercise = $form->getData();
//            $entityManager->persist($exercise);
//            $entityManager->flush();
//            return $this->render('operation_success.html.twig', ['type' => 'exercise']);
//        }
        return $this->render('Exercises\edit-exercise.html.twig', ['form' => $form, ]);
    }

    #[Route('/exercise/{id}',name: 'exercise_edit', methods: ['PUT'])]
    public function edit(Request $request, ExerciseRepository $exerciseRepository,EntityManagerInterface $entityManager, int $id): Response{
        $exercise = $exerciseRepository->find($id);
        $form = $this->createForm(ExerciseType::class, $exercise, ['action' => $this->generateUrl('exercise_edit', ['id' => $exercise->getId()]),
            'method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exercise = $form->getData();
            $entityManager->persist($exercise);
            $entityManager->flush();
            return $this->render('operation_success.html.twig', ['type' => 'exercise']);
        }
        return $this->render('Exercises\edit-exercise.html.twig', ['form' => $form, ]);
    }

    #[Route('/exercise/{id}/delete-form', name: 'show_exercise_delete', methods: ['GET'])]
    public function showDeleteForm(Request $request, int $id, ExerciseRepository $exerciseRepository, EntityManagerInterface $entityManager): Response
    {
        //$exercise = $exerciseRepository->find($id);
        $form = $this->createForm(DeleteButtonType::class, null, [
            'action' => $this->generateUrl('exercise_delete', ['id' => $id]),
            'method' => 'DELETE',
        ]);

        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->remove($exercise);
//            $entityManager->flush();
//            return $this->render('delete_success.html.twig', ['type' => 'exercise']);
//        }
        return $this->render('deleteConfirmation.html.twig', ['form' => $form, 'type' => 'exercise']);


    }

    #[Route('/exercise/{id}', name: 'exercise_delete', methods: ['DELETE'])]
    public function delete(Request $request, int $id, ExerciseRepository $exerciseRepository, EntityManagerInterface $entityManager): Response
    {
        $exercise = $exerciseRepository->find($id);
        $form = $this->createForm(DeleteButtonType::class, null, [
            'action' => $this->generateUrl('exercise_delete', ['id' => $id]),
            'method' => 'DELETE',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($exercise);
            $entityManager->flush();
            return $this->render('delete_success.html.twig', ['type' => 'exercise']);
        }
        return $this->render('deleteConfirmation.html.twig', ['form' => $form, 'type' => 'exercise']);

    }

}