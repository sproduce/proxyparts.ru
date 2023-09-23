<?php
namespace App\Repository\Interfaces;
use App\Entity\Seller;


interface SellerRepositoryInterface {
    
public function getSeller($sellerId): Seller;


    
}
