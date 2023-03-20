<?php
namespace App\Repository\Interfaces;

use App\Entity\PartsHistory;
//use App\Entity\Parts;


interface PartsRepositoryInterface {
    
  
    public function search($number);
    
    public function searchPartsHistory($number): PartsHistory;
    public function getPartsHistory($id): PartsHistory;
    public function storePartsHistory(PartsHistory $partsHistoryObj): PartsHistory;

    
}
