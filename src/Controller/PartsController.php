<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;
//use Symfony\Component\Uid\Uuid;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PartsController extends AbstractController
{
    private $userObj;
    private $partsServ;
    private $request;
    
    function __construct(Security $security, \App\Service\PartsService $partsServ, RequestStack $requestStack)
    {
        $this->userObj = $security->getUser();
        $this->partsServ = $partsServ;
        $this->request = $requestStack->getCurrentRequest();
    }
    
    
    
    /**
     * @Route("/search/{partsNumber}")
     */
    public function search($partsNumber = null): Response 
    {
        if (is_null($partsNumber)){
            $partsNumber = $this->request->query->get('partsNumber');
        }
        if ($partsNumber){
            $parts = $this->partsServ->searchParts($partsNumber);
            if (count($parts)==1){
                $id = $parts[0]->getId();
                return $this->redirect('/searchId/'.$id);
            } else {
                return $this->render('Parts/searchResult.html.twig', [
                    'partsNumber' => $partsNumber,
                    'parts' => $parts,
                ]);
            }
            
        } else {
            $this->addFlash('error', 'Введите номер запчсти для поиска');
            return $this->redirect("/");
        }
       
    }
    
    
    
    /**
     * @Route("/search/{brand}/{partsNumber}")
     */
    public function searchByBrand($brand,$partsNumber)
    {
        $partObj = null;
       return $this->render('Parts/partInfo.html.twig', [
                    'partObj' => $partObj,
                ]);
    }

    
    
     /**
     * @Route("/searchId/{partId}")
     */
    public function searchById($partId)
    {
        
        $partObj = $this->partsServ->getPart($partId);
        
        $sellersObj = $this->partsServ->getSellerParts($partObj);
        
        return $this->render('Parts/partSellers.html.twig', [
                    'partObj' => $partObj,
                    'sellersObj' => $sellersObj,
                ]);
    }
    
    
    
    
    
    /**
     * @Route("/searchSalers/{partsId}")
     */
    public function searchSalers($partsId): Response
    {
        
    }
    
    
    
    
    
    /**
     * @Route("/parts/add/{partId}")
     */
    public function add($partId = null): Response 
    {
        $userParts = $this->partsServ->getUserPart();
        $items = [
            'brand' => $userParts->getParts()->getBrand(), 
            'parts' => $userParts->getParts(), 
            'userParts' => $userParts
        ];
        
        $form = $this->createFormBuilder($items)
                ->add('brand', \App\Form\Type\BrandFormType::class)
                ->add('parts', \App\Form\Type\PartsFormType::class)
                ->add('userParts', \App\Form\Type\UserPartsFormType::class)
                ->add('submit', SubmitType::class)
                ->getForm();
        
        $form->handleRequest($this->request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->partsServ->storeUserParts($this->userObj, $userParts);
            $this->addFlash('success', 'Запчасть добавлена');
            return $this->redirect("/parts/add");
        } else {
            return $this->renderForm('Parts/add.html.twig', ['form' => $form]);
        }
    }
    
    
    /**
     * @Route("/parts/user")
     */
    public function listUserParts(): Response 
    {
        $pageNumber = $this->request->query->get('pageNumber');
        $userPartsObj = $this->partsServ->getUserParts($this->userObj,$pageNumber);
        //var_dump($userPartsObj);
        return $this->render('Parts/userParts.html.twig',['userParts' => $userPartsObj]);
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