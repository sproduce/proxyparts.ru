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
    
    private function brandUpper($brand)
    {
        return strtoupper($brand);
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
            $uuid4 = Uuid::v4(); 
            $brandObj->setUuid($uuid4->toBinary());
            $brandObj = $this->partsRep->storeBrand($brandObj);
        }
        
        return $brandObj;
    }
    
    
    public function getPartByNumber(Parts $searchPartObj, Brand $brandObj) 
    {
        $partObj = $this->partsRep->searchPart($searchPartObj->getNumber(), $brandObj);
        if (!$partObj->getId()){
            $partObj->setBrand($brandObj);
            $partObj->setNumber($searchPartObj->getNumber());
            $partObj->setNumberText($searchPartObj->getNumberText());
            $partObj->setInfo($searchPartObj->getInfo());
            $uuid4 = Uuid::v4(); 
            $partObj->setUuid($uuid4->toBinary());
            $partObj = $this->partsRep->storePart($partObj);
        }
        
        return $partObj;
    }
    
    
    
    
    
    
    public function getUserPart($userPartId = null): UserParts
    {
        
        
        
        return $this->partsRep->getUserPart($userPartId);
    }
    
    
    
    
    
    
    
    
    
    public function storeUserParts(User $userObj, UserParts $userPartsObj) 
    {
        //var_dump($userObj);
        //var_dump($userPartsObj);
        $partsObj = $userPartsObj->getParts();
        $partsObj->setNumber($this->cleanNumber($partsObj->getNumberText()));
        $userPartsObj->setInfo($partsObj->getInfo());
        
        $brandObj = $partsObj->getBrand();
        $brandObj->setName($this->brandUpper($brandObj->getName()));
        
        $brandExist = $this->getBrandByName($brandObj->getName());
        
        $partExist = $this->getPartByNumber($partsObj, $brandExist);
        
        $userPartsObj->setParts($partExist);
        if (!$userPartsObj->getId()){
            $uuid4 = Uuid::v4(); 
            $userPartsObj->setUuid($uuid4->toBinary());
            $userPartsObj->setUser($userObj);
        }
        
        $this->partsRep->storeUserPart($userPartsObj);
        //var_dump($userPartsObj);
        
        
        //exit();
    }
    
    
    
    
}
