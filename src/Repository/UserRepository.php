<?php
namespace App\Repository;

use App\Repository\Interfaces\UserRepositoryInterface;
use App\Entity\User;


class UserRepository implements UserRepositoryInterface
{
    private $dbh;
    public function __construct()
    {
        $this->dbh = \Core_static::loadPdo();
    }
    
    
    public function getUser($userId): User
    {
        return new User();
    }
}
