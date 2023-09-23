<?php
namespace App\Repository;

use App\Repository\Interfaces\SellerRepositoryInterface;

use App\Lib\Core_static;
use App\Entity\Seller;


class SellerRepository implements SellerRepositoryInterface
{
    private $dbh;
    private $seller = [];
    
    
    public function __construct()
    {
        $this->dbh = Core_static::loadPdo();
    }
    
    
    public function getSeller($sellerId): Seller
    {
        if (!isset($this->seller[$sellerId])){
            $sql = 'select * from user where id=:sellerId';
            $sth = Core_static::getPDOStatement($sql);
            $sth->bindParam(':sellerId',$sellerId,\PDO::PARAM_INT);
            $sth->execute();
            $this->seller[$sellerId] = $sth->fetchObject('App\Entity\Seller')?: new Seller();
        }
        
        return $this->seller[$sellerId];
    }
    
    
    
    
}
