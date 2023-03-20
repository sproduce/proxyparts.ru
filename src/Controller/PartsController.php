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
        
    }
    
    
     /**
     * @Route("/search/{partsNumber}")
     */
    public function search($partsNumber = null, Request $request, \App\Service\PartsService $partsServ): Response 
    {
        if (is_null($partsNumber)){
            $partsNumber = $request->query->get('partsNumber');
        }
        if ($partsNumber){
            $partsServ->searchParts($partsNumber);
            return $this->render('parts/searchResult.html.twig', [
            'partsNumber' => $partsNumber,
            ]);
        } else {
            $this->addFlash('error', 'Введите номер для поиска');
            return $this->redirect("/");
        }
       
    }
    
}