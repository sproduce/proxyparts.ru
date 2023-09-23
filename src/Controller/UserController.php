<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\RegisterFormType;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\FormError;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends AbstractController
{
    private $userServ,$userObj;
            
    public function __construct(UserService $userServ, Security $security)
    {
        $this->userServ = $userServ;
        $this->userObj = $security->getUser();
    }
          
 
    private function authNewUser(User $userObj)
    {
        $token = new UsernamePasswordToken($userObj,null,$userObj->getRoles());
        //$this->container->get('security.token_storage')->setToken($token);
    }
    
     
    /**
     * @Route("/user/register", name="app_register")
     */
    public function register(Request $request): Response
    {
        $userObj = new User();
        $form = $this->createForm(RegisterFormType::class,$userObj);        
         
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recaptcha = new \ReCaptcha\ReCaptcha($_ENV['GOOGLE_CAPTHCA_SECRET']);
            $gToken = $request->get('g-recaptcha-response');
            $clientIp = $request->getClientIp();
            $resp = $recaptcha->verify($gToken, $clientIp);
            if($resp->isSuccess()){
                $userObj = $form->getData();
                if ($this->userServ->storeUser($userObj)){
                    $this->authNewUser($userObj);
                    return $this->redirect("/");
                } else {
                    $form->get('email')->addError(new FormError('Такой адрес уже зарегистрирован'));
                }
            }
            
             
             
        }
//         $this->addFlash('error', 'test');
//         $this->addFlash('success', 'test11');
//         $this->addFlash('notice', 'test2');
        return $this->renderForm('User/register.html.twig', [
            'form' => $form,
        ]);
    }
    
    
     /**
     * @Route("/user/loginDialog")
     */
    public function loginDialog(): Response
    {
        return $this->render('Dialog/login.html.twig');
    }
    
    
    /**
     * @Route("/user/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->renderForm('authIndex.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
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
        //var_dump($this->userObj);
        return $this->render('User/profile.html.twig');
    }
    
    
    
    /**
     * @Route("/user/test")
    */ 
    public function test(): Response
    {
        return $this->render('authIndex.html.twig');
    }
    
    
    
    
}
