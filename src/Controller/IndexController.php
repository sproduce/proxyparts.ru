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
        //$userId = \Core_static::checkAccess();
    }
    
    
    /**
     * @Route("/")
     */
    public function show(): Response
    {
        return $this->render('Index/index.html.twig');
    }
    
    
     /**
     * @Route("/about")
     */
    public function about(): Response
    {
        return $this->render('Index/about.html.twig');
    }
    
  
}