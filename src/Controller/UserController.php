<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterFormType;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\FormError;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends AbstractController
{
    private $userServ,$userObj;
            
    public function __construct(UserService $userServ, Security $security)
    {
        $this->userServ = $userServ;
        $this->userObj = $security->getUser();
    }
            
     
    /**
     * @Route("/user/register")
     */
    public function register(Request $request): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');
        $userObj = new User();
        $form = $this->createForm(RegisterFormType::class,$userObj);        
         
        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
             $userObj = $form->getData();
             $this->userServ->storeUser($userObj);
             
            // $form->get('email')->addError(new FormError('Такой адрес уже зарегистрирован'));
             
             return $this->redirect("/");
         }
//         $this->addFlash('error', 'test');
//         $this->addFlash('success', 'test11');
//         $this->addFlash('notice', 'test2');
        return $this->renderForm('User/register1.html.twig', [
            'form' => $form,
        ]);
    }
    
    
    /**
     * @Route("/user/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        //return $this->redirect("/");
        //$form = $this->createForm(LoginFormType::class); 
        return $this->renderForm('Dialog/login.html.twig');
            
    }

   
        
    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
    


    
    /**
     * @Route("/user/profile")
    */ 
    public function profile(): Response
    {
        return $this->render('User/profile.html.twig');
    }
}
