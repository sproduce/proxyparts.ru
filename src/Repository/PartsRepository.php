<?php
namespace App\Repository;

use App\Repository\Interfaces\PartsRepositoryInterface;
//use App\Entity\User;


class PartsRepository implements PartsRepositoryInterface
{
    private $dbh;
    public function __construct()
    {
        $this->dbh = \Core_static::loadPdo();
    }
    
}
