<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\Type\DeleteButtonType;
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
    public function show_user_list(UserRepository $userRepository,Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $offset = ($page - 1) * $limit;

        $totalUsers = $userRepository->count([]);
        $users = $userRepository->findBy([], null, $limit, $offset);

        return $this->render('User/user_list.html.twig', [
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => ceil($totalUsers / $limit)
        ]);

    }

    #[Route('/user/{id}', name: 'individualUser', methods: ["GET"])]
    public function show_user(UserRepository $userRepository, int $id): Response
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

    #[Route('/user/{id}/edit-form',name: 'show_user_edit', methods: ['GET'])]
    public function showEditForm(Request $request, UserRepository $userRepository,EntityManagerInterface $entityManager, int $id): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user, ['action' => $this->generateUrl('user_edit', ['id' => $id]),
            'method' => 'PUT']);
        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
//            $user = $form->getData();
//            $entityManager->persist($user);
//            $entityManager->flush();
//            return $this->render('operation_success.html.twig', ['type' => 'user']);
//        }
        return $this->render('User\edit-user.html.twig', ['form' => $form, ]);
    }

    #[Route('/user/{id}',name: 'user_edit', methods: ['PUT'])]
    public function edit(Request $request, UserRepository $userRepository,EntityManagerInterface $entityManager, int $id): Response{
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user, ['action' => $this->generateUrl('user_edit', ['id' => $user->getId()]),
            'method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $user = $form->getData();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->render('operation_success.html.twig', ['type' => 'user']);
        }
        return $this->render('User\edit-user.html.twig', ['form' => $form, ]);
    }

    #[Route('/user/{id}/delete-form', name: 'show_user_delete', methods: ['GET'])]
    public function showDeleteForm(Request $request, int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        //$user = $userRepository->find($id);
        $form = $this->createForm(DeleteButtonType::class,null, [
            'action' => $this->generateUrl('user_delete', ['id' => $id]),
            'method' => 'DELETE',
        ]);

//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->remove($user);
//            $entityManager->flush();
//            return $this->render('delete_success.html.twig', ['type' => 'user']);
//        }
        return $this->render('deleteConfirmation.html.twig', ['form' => $form, 'type' => 'user']);

    }
    #[Route('/user/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(Request $request, int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(DeleteButtonType::class,null, [
            'action' => $this->generateUrl('user_delete', ['id' => $id]),
            'method' => 'DELETE',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($user);
            $entityManager->flush();
            return $this->render('delete_success.html.twig', ['type' => 'user']);
        }
        return $this->render('deleteConfirmation.html.twig', ['form' => $form, 'type' => 'user']);

    }


}