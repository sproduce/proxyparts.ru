<?php

namespace App\Service;

use App\Repository\Interfaces\UserRepositoryInterface;
use App\Entity\User;

class UserService {
    private $userRep;
    
    public function __construct(UserRepositoryInterface $userRep)
    {
        $this->userRep = $userRep;
    }
    
    
    
    private function notRepeatValue(User $userObj)
    {
        if ($this->userRep->isEmailExist($userObj) || $this->userRep->isPhoneExist($userObj)){
            return false;
        } else {
            return true;
        }
    }
    
    
    
    
    public function changePasswd() 
    {
        
    }
    
    
    
    public function storeUser(User $userObj) 
    {
        if ($userObj->getPhone()){
            $userObj->setPhoneCanonical('+'.preg_replace('~\D~','',$userObj->getPhone()));
        }
        
        
        if($userObj->getId()){
            $this->userRep->update($userObj);
        } else {
            $userObj->setKey(hex2bin(md5(uniqid(rand(), true))));
            $userObj->setPasswd(password_hash($userObj->getPasswd(),PASSWORD_DEFAULT));
            if ($this->notRepeatValue($userObj)){
                $this->userRep->add($userObj);
            }
            
        }
    }
    
    public function getUser($id): User 
    {
        $userObj = $this->userRep->get($id);
        return $userObj;
    }
    
    
}
