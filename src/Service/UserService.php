<?php

namespace App\Service;

use App\Repository\Interfaces\UserRepositoryInterface;


class UserService {
    private $userRep;
    
    public function __construct(UserRepositoryInterface $userRep)
    {
        $this->userRep = $userRep;
    }
    
    public function addUser() 
    {
        $this->userRep->getUser(10);
    }
    
    
    
    
}
