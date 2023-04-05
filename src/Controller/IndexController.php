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
    
    
    
    /**
     * @Route("/contact")
     */
    public function contact(): Response
    {
        return $this->render('Index/contact.html.twig');
    }
    
    
    
    /**
     * @Route("/news")
     */
    public function news(): Response
    {
        return $this->render('Index/news.html.twig');
    }
  
    
    /**
     * @Route("/apiInfo")
     */
    public function apiInfo(): Response
    {
        return $this->render('Index/apiInfo.html.twig');
    }
    
    
    
}