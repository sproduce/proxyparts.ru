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
    
    
    
    private function updateHistory($cleanNumber)
    {
        $historyObj = $this->partsRep->searchPartsHistory($cleanNumber);
        
        $historyObj->setNumber($cleanNumber);
        $historyObj->setRequest($historyObj->getRequest()+1);
        $historyObj->setUpdate(date('Y-m-d H:i:s', time()));
        $this->partsRep->storePartsHistory($historyObj);
    }
    
    
    
    
    public function searchParts($number)
    {
        $cleanNumber = $this->cleanNumber($number);
        $this->updateHistory($cleanNumber);
        $result = $this->partsRep->search($cleanNumber);
        
        
        return $result;
    }
    
    
}
