<?php
namespace App\Repository;

use App\Repository\Interfaces\SellerRepositoryInterface;

use App\Lib\Core_static;



class SellerRepository implements SellerRepositoryInterface
{
    private $dbh;
    
    public function __construct()
    {
        $this->dbh = Core_static::loadPdo();
    }
    
    
    
}
