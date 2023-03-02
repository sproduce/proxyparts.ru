<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    
    
    /**
     * @Route("/user/register")
     */
    public function register(): Response
    {
        $userObj = new User();
//        $form = $this->createFormBuilder($userObj)
//                ->add('name')
//                ->add('nickName')
//                ->add('save',SubmitType::class)
//                ->getForm()->createView();
                
        $userObj->setName('test');
         $form = $this->createForm(UserFormType::class)->createView();        
                
        return $this->render('user/register1.html.twig', [
            'form' => $form,
        ]);
    }
    
         
     /**
     * @Route("/user/register", methods={"POST"})
     */
    public function storeUser(Request $request) 
    {
        $user = new User();
        
        //echo $this->getParameter('app.google_capthca_secret');
        return $this->redirect("/");
    }
    
    
    
}
