<?php
namespace App\Repository;

use App\Repository\Interfaces\UserRepositoryInterface;
use App\Entity\User;
use App\Lib\Core_static;

class UserRepository implements UserRepositoryInterface
{
    private $dbh;
    public function __construct()
    {
        $this->dbh = Core_static::loadPdo();
    }
    
    
    public function get($userId): User
    {
        $sql = "select * from user where id=?";
        
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$userId]);
        $result = $sth->fetchObject("App\Entity\User");
        return $result ?: new User();
    }
    
    
    
    public function getUserByEmail($email): User
    {
        $sql = "select * from user where email=?";
        
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$email]);
        $result = $sth->fetchObject("App\Entity\User");
        return $result ?: new User();
    }
    
    
    
    
    
    public function store(User $userObj): User {
        if ($userObj->getId()){
            $sql = "update into user set name=?,nickname=?,passwd=?,email=?,telegramChatId=?,
                                     phone=?,phoneCanonical=?,keyMd5=? 
                            where id=?";
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([
            $userObj->getName(),
            $userObj->getNickName(),
            $userObj->getPasswd(),
            $userObj->getEmail(),
            $userObj->getTelegramId(),
            $userObj->getPhone(),
            $userObj->getPhoneCanonical(),
            $userObj->getKey(),
            $userObj->getId(),
            ]);

        return $this->get($userObj->getId());
        } else {
            $sql = "insert into user (name,nickname,passwd,email,telegramChatId,phone,phoneCanonical,keyMd5) 
                            values(?,?,?,?,?,?,?,?)";   
            $sth = Core_static::getPDOStatement($sql);
            $sth->execute([
                $userObj->getName(),
                $userObj->getNickName(),
                $userObj->getPasswd(),
                $userObj->getEmail(),
                $userObj->getTelegramId(),
                $userObj->getPhone(),
                $userObj->getPhoneCanonical(),
                $userObj->getKey(),
                ]);
            $lastId = $this->dbh->lastInsertId();
            return $this->get($lastId);
        }

    }
   
    
    
    
    public function update(User $userObj): User {

    }
    
    
    public function isPhoneExist(User $userObj): bool {
        $sql = "select count(id) from user where if(:id, id<>:id and phone=:phone, phone=:phone)";
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([
            ':id' => $userObj->getId(),
            ':phone' => $userObj->getPhone()
        ]);
        if ($sth->fetchColumn()){
            return true;
        } else {
            return false;
        }
    }
    
    public function isEmailExist(User $userObj): bool {
        $sql = "select count(id) from user where if(:id, id<>:id and email=:email, email=:email)";
        
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([
            ':id' => $userObj->getId(),
            ':email' => $userObj->getEmail()
        ]);
        if ($sth->fetchColumn()){
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    
}
