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
    
    
    public function get($userId): User
    {
        $sql = "select user_id as id,
                       user_name as name,
                       user_nickname as nickname,
                       user_passwd as passwd,
                       user_email as email,
                       user_telegram_chat_id as telegramId,
                       user_phone as phone,
                       user_phone_canonical as phoneCanonical,
                       user_key_md5 as keyMd5
                from pp_user where user_id=?";
        
        $sth = \Core_static::getPDOStatement($sql);
        $sth->execute([$userId]);
        $result = $sth->fetchObject("App\Entity\User");
        return $result ?? new User();
    }
    
    
    public function add(User $userObj): User {
        $sql = "insert into pp_user (user_name,
                                     user_nickname,
                                     user_passwd,
                                     user_email,
                                     user_telegram_chat_id,
                                     user_phone,
                                     user_phone_canonical,
                                     user_key_md5) 
                        values(?,?,?,?,?,?,?,?)";   
        $sth = \Core_static::getPDOStatement($sql);
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
    
    
    
    
    public function update(User $userObj): User {
         $sql = "update into pp_user set user_name=?,
                                     user_nickname=?,
                                     user_passwd=?,
                                     user_email=?,
                                     user_telegram_chat_id=?,
                                     user_phone as phone=?,
                                     user_phone_canonical=?,
                                     user_key_md5=? 
                        where user_id=?";
        $sth = \Core_static::getPDOStatement($sql);
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
    }
    
    
    public function isPhoneExist(User $userObj): bool {
        $sql = "select count(user_id) from pp_user where user_id<>? and user_phone=?";
        $sth = \Core_static::getPDOStatement($sql);
        $sth->execute([$userObj->getId(),$userObj->getPhone()]);
        if ($sth->fetchColumn()){
            return true;
        } else {
            return false;
        }
    }
    
    
}
