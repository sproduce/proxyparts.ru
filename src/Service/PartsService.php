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
    
    
    private function cleanNumber($number)
    {
        $number_tmp = preg_replace("/[^a-z0-9]/","",strtolower(trim($number)));

        return $number_tmp;
    }  
    
    public function searchParts($number)
    {
        $clearNumber = $this->cleanNumber($number);
        $result = $this->partsRep->search($clearNumber);
        $historyObj = $this->partsRep->searchPartsHistory($clearNumber);
        
        $historyObj->setNumber($clearNumber);
        $historyObj->setRequest($historyObj->getRequest()+1);
        $historyObj->setUpdate(date('Y-m-d H:i:s', time()));
        $this->partsRep->storePartsHistory($historyObj);
        
        return $result;
    }
    
    
}
