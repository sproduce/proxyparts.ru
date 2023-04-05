<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;


class PartsController extends AbstractController
{
    private $userObj;
    private $partsServ;
    
    function __construct(Security $security, \App\Service\PartsService $partsServ)
    {
        $this->userObj = $security->getUser();
        $this->partsServ = $partsServ;
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
            
            return $this->render('Parts/searchResult.html.twig', [
            'partsNumber' => $partsNumber,
            ]);
        } else {
            $this->addFlash('error', 'Введите номер для поиска');
            return $this->redirect("/");
        }
       
    }
    
    
    /**
     * @Route("/parts/add/{partId}")
     */
    public function add($partId = null, Request $request): Response 
    {
//        
//        $user = new User();
//$company = new Company();
//$items = ['user' => $user, 'company' => $company];
//
//$form = $this->createFormBuilder($items)
//    ->add('user', UserType::class)
//    ->add('company', CompanyType::class)
//    ->add('save', SubmitType::class, ['label' => 'Do Something'])
//     ->getForm();
//        
        
        
        
       return $this->renderForm('Parts/add.html.twig');
    }
    
    
    /**
     * @Route("/parts/user")
     */
    public function listUserParts(): Response 
    {
        return $this->render('Parts/userParts.html.twig');
    }
    
    
    /**
     * @Route("/parts/preference")
     */
    public function userPreference(): Response 
    {
        return $this->render('Parts/preference.html.twig');
    }
    
    
    
    /**
     * @Route("/parts/parse")
     */
    public function parse(): Response 
    {
        return $this->render('Parts/parse.html.twig');
    }
    
    
    
    
    
    
}