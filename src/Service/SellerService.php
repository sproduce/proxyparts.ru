<?php

namespace App\Service;

use App\Repository\Interfaces\SellerRepositoryInterface;
use App\Entity\Parts;
//use Symfony\Component\Uid\Uuid;




class SellerService {
    private $sellerRep;
    
    public function __construct(SellerRepositoryInterface $sellerRep)
    {
        $this->sellerRep = $sellerRep;
    }
    
    
    
    public function getSellersByPart(Parts $partObj) 
    {
        
    }
    
    
        
    
}
