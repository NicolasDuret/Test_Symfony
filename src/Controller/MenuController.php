<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    // Pas de route pour les vues partielles
    public function index()
    {
        return $this->render('menu/_menu.html.twig', [ //on met un "_" pour dire que c'est une vue partielle
            'controller_name' => 'HomeController',
        ]);
    }
}
