<?php
// src/Controller/LuckyController.php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class IndexController extends AbstractController
{
    function __construct()
    {
        $userId = \Core_static::checkAccess();
    }
    
    
    /**
     * @Route("/")
     */
    public function show(\App\Service\UserService $userServ): Response
    {
        return $this->render('index.html.twig');
    }
    
    
    /**
     * @Route("/register", methods={"GET"})
     */
    public function register() 
    {
        return $this->render('user/register.html.twig');
    }
    
    
     /**
     * @Route("/register", methods={"POST"})
     */
    public function storeUser() 
    {
        //echo $this->getParameter('app.google_capthca_secret');
        return $this->redirect("/");
    }
    
}