<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{

    #[Route('/', name: 'home')]
    public function home_menu():Response
    {
        return $this->render('HomeController\home.html.twig');
    }
}
?>