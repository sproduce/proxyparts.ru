<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class PartsController extends AbstractController
{
    private $userObj;
    
    function __construct()
    {
        $userId = \Core_static::checkAccess();
    }
    
    
     /**
     * @Route("/search")
     */
    public function search() 
    {
        return $this->redirect("/");
    }
    
}