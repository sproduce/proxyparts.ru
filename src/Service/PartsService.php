<?php

namespace App\Service;

use App\Repository\Interfaces\PartsRepositoryInterface;
use App\Entity\Parts;

class PartsService {
    private $partsRep;
    
    public function __construct(PartsRepositoryInterface $partsRep)
    {
        $this->partsRep = $partsRep;
    }
    
    
    
    
}
