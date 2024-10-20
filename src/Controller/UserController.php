<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\SecurityBundle\Security;
use App\Form\Type\PartsOfferFormType;
use App\Service\PartsService;


class UserController extends AbstractController
{
    private $userObj;
    private $partsServ;
    public function __construct(Security $security, PartsService $partsServ)
    {
        $this->userObj = $security->getUser();
        $this->partsServ = $partsServ;
    }
    
    
    
    
    #[Route('/user/offers', name: 'app_user_offers')]
    public function listOffers(): Response
    {
        $partsOffers = $this->partsServ->getUserOffers($this->userObj);
        
        return $this->render('user/parts.html.twig',[
            'partsOffers' => $partsOffers,
        ]);
    }
    
    
    
    
    #[Route('/user/addOffer/{id}', name: 'app_user_add_offer', defaults: ['id' => 0], methods: ['GET'])]
    public function addPartsOffer(int $id , PartsService $partsServ): Response
    {
        $partsOffer = $partsServ->getUserOffer($this->userObj, $id);
        
        if ($partsOffer->getId()) {
            $formOptions = ['Save' => 'Save'];
        } else {
            $formOptions = [];
        }
        
        $form = $this->createForm(PartsOfferFormType::class, $partsOffer, $formOptions);
         
        return $this->render('defaultForm.html.twig',[
            'form' => $form,
        ]);
    }
    
    
    #[Route('/user/addOffer/{_id}', name: 'app_user_store_offer', methods: ['POST'])]
    public function storePartsOffer(PartsService $partsServ ,Request $request): Response
    {
        $partsOffer = $partsServ->getUserOffer($this->userObj);
        $form = $this->createForm(PartsOfferFormType::class, $partsOffer);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $partsServ->storeUserOffer($partsOffer, $this->userObj);
            $this->addFlash('success', 'Запчасть Сохранена');
            return $this->redirectToRoute('app_user_offers');
        } 
         
        return $this->render('defaultForm.html.twig',[
            'form' => $form,
        ]);
    }
    
    
    
    
    
    
    
    
    
    
    #[Route('/user/profile', name: 'app_user_profile')]
    public function profile(): Response
    {
        return $this->render('index/index.html.twig');
    }
    
    
    
    
}
