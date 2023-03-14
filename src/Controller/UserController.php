<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterFormType;
use App\Form\LoginFormType;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class UserController extends AbstractController
{
    private $userServ;
            
    public function __construct(UserService $userServ)
    {
        $this->userServ = $userServ;
    }
            
            
            
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
    public function register(Request $request): Response
    {
        $userObj = new User();
        $form = $this->createForm(RegisterFormType::class,$userObj);        
         
        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
             $userObj = $form->getData();
             $this->userServ->storeUser($userObj);
             return $this->redirect("/");
         }
//         $this->addFlash('error', 'test');
//         $this->addFlash('success', 'test11');
//         $this->addFlash('notice', 'test2');
        return $this->renderForm('user/register1.html.twig', [
            'form' => $form,
        ]);
    }
    
    
    /**
     * @Route("/user/login")
     */
    
        public function login(Request $request): Response
        {
            //return $this->redirect("/");
            $form = $this->createForm(LoginFormType::class); 
            return $this->renderForm('Dialog/login.html.twig', [
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
