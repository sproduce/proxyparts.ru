<?php
namespace App\Repository\Interfaces;

use App\Entity\PartsHistory;
use App\Entity\Brand;
use App\Entity\Parts;
use App\Entity\UserParts;


interface PartsRepositoryInterface {
    
  
    public function search($number);//return readModel[]
    
    public function getPart($partId): Parts;
    public function getParts($brandId,$page = null);
    public function searchParts($number);
    public function searchPart($number, Brand $brand): Parts;
    
    

    
    public function searchPartsHistory($number): PartsHistory;
    public function getPartsHistory($id): PartsHistory;
    public function storePartsHistory(PartsHistory $partsHistoryObj): PartsHistory;

    
    
    public function getBrand($brandId): Brand;
    public function getBrandByName($brand): Brand;
    public function storeBrand(Brand $brand): Brand;
    
    public function storeParts(Parts $partsObj): Parts;

    
    public function getUserPart($userPartsId): UserParts;

    
}
