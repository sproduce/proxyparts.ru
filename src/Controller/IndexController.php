<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class IndexController extends AbstractController
{
    private $userObj;
    
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
    public function register(): Response
    {
        return $this->render('user/register.html.twig');
    }
    
   
}