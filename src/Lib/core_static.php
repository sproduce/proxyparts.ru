<?php
use Sproduce\JWT\JWT;
class Core_static
{

private static $pdo = null;
private static $userId = null;


private static $pdo_host = 'localhost';
private static $pdo_db = 'proxyparts';
private static $pdo_user = 'proxyparts';
private static $pdo_passwd = 'proxyparts';

private static $pdoStatement;
private static $noticeArray;









public static function checkAccess()
{
    if (is_null(self::$userId)){
        self::$userId = 0;
        $token = filter_input(INPUT_COOKIE,'aToken');
        if ($token){
            JWT::loadPublicKeyFromFile("../app/config/public.key");
            $userArray = JWT::decode($token);
            if ($userArray){
                if($userArray["iss"] == self::$domainName){
                    self::$userId = $userArray["userid"];
                }
            } else {
                setcookie('aToken', null, -1, '/');
            }
        }
    } 
    
    return self::$userId;
}




 public static function add_notice($notice)
    {
     
        setcookie("notice_text",$notice,time()+100,'/');
        
        
    }

  
   
    
    
    public static function loadPdo(): PDO
    {
        if (!self::$pdo){
            self::$pdo = new PDO('mysql:host='.self::$pdo_host.';dbname='.self::$pdo_db.';charset=utf8', self::$pdo_user, self::$pdo_passwd);
            self::$pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
        }
        return self::$pdo;
    }
    
    
  
     public static function getPDOStatement($sql): PDOStatement
    {
        $pdo = self::loadPdo();
        $md5sql = md5($sql);
        if (empty(self::$pdoStatement[$md5sql])){
            self::$pdoStatement[$md5sql] = $pdo->prepare($sql);
        }
        return self::$pdoStatement[$md5sql];
    }
    
    
  
}

