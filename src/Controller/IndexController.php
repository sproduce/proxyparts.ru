<?php
// src/Controller/LuckyController.php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function show(): Response
    {
        $number = random_int(0, 100);

        return $this->render('index.html.twig');

    }
}