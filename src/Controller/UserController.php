<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function show_exercise_list(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('User\user_list.html.twig', ['users' => $users]);

    }

    #[Route('/user/{id}', name: 'individualUser')]
    public function show_exercise(UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found with id: ' . $id
            );
        }
        return $this->render('User\individual_user.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/register',name: 'register', methods: array('GET', 'POST'))]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('User\addUserPage.html.twig', ['form' => $form, ]);    }
}