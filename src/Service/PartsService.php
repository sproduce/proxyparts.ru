<?php

namespace App\Service;

use App\Repository\Interfaces\PartsRepositoryInterface;
use Symfony\Component\Uid\Uuid;

use App\Entity\Parts;
use App\Entity\Brand;
use App\Entity\UserParts;
use App\Entity\User;


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
    
    
    
    public function getPart($partId = null): Parts
    {
        return $this->partsRep->getPart($partId);
    }
    
    
    public function getBrand($brandId = null): Brand 
    {
        return $this->partsRep->getBrand($brandId);
    }
    
    
    
    public function getBrandByName($brand): Brand 
    {
        $brandObj = $this->partsRep->getBrandByName($brand);
        if (!$brandObj->getId()){
            $brandObj->setName($brand);
            $brandObj = $this->partsRep->storeBrand($brandObj);
        }
        
        return $brandObj;
    }
    
    
    public function getPartByNumber($number, Brand $brandObj) 
    {
        $partObj = $this->partsRep->searchPart($number, $brandObj);
        if (!$partObj->getId()){
            $partObj->setBrandId($brandObj->getId());
            $partObj->setNumber($number);
            //$partsObj = $this->partsRep->sto
        }
        
    }
    
    
    
    
    
    
    public function getUserPart($userPartId = null): UserParts
    {
        return $this->partsRep->getUserPart($userPartId);
    }
    
    
    public function storeUserParts(User $userObj, UserParts $userPartsObj) 
    {
        var_dump($userObj);
        var_dump($userPartsObj);
        $partsObj = $userPartsObj->getParts();
        $brandObj = $partsObj->getBrand();
        $brandObj = $this->getBrandByName($brandObj->getName());
        
        
        
        //exit();
    }
    
    
    
    
}
