<?php
namespace App\Repository;

use App\Repository\Interfaces\PartsRepositoryInterface;
use App\Entity\PartsHistory;
use App\Lib\Core_static;

use App\Entity\Brand;
use App\Entity\Parts;
use App\Entity\UserParts;


class PartsRepository implements PartsRepositoryInterface
{
    private $dbh;
    private $userRep;
    private $part = [];
    private $brand = [];
    
    public function __construct(Interfaces\UserRepositoryInterface $userRep)
    {
        $this->dbh = Core_static::loadPdo();
        $this->userRep = $userRep;
    }
    
    
    
    
    public function search($number) //return readModel[]
    {
        $sql = 'select pn.id,
                       pn.number, 
                       pn.numberText, 
                       pn.info,
                       pn.uuid,
                       pn.brandId,
                       pb.name as brandName,
                       pb.uuid as brandUuid
                from 
                       parts_number as pn,parts_brand as pb
                where
                       pb.id=pn.brandId and
                       pn.number=?';
        
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$number]);
        
        $result = $sth->fetchAll(\PDO::FETCH_CLASS,'App\Entity\PartsRead');
        
        return $result;
    }
    


    public function searchParts($number) 
    {
        $sql = 'select * from parts_number where number=?';
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$number]);
        $resultParts = $sth->fetchAll(\PDO::FETCH_CLASS,'App\Entity\Parts');
        if ($resultParts){
            foreach($resultParts as $part){
                $part->setBrand($this->getBrand($part->getBrandId()));
                if ($part->getParentId()){
                    $part->setParent($this->getPart($part->getParentId()));
                }
            }
        }
        return $resultParts;
    }

    
    
    public function searchPart($number, Brand $brand): Parts 
    {
        $sql = 'select * from parts_number where number=? and brandId=?';
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$number,$brand->getId()]);
        $partObj = $sth->fetchObject('App\Entity\Parts')?: new Parts();
        $partObj->setBrand($brand);
        if ($partObj->getParentId()){
            $partObj->setParent($this->getPart($partObj->getParentId()));
        }
        return $partObj;
    }

    
    
   



    public function searchPartsHistory($number): PartsHistory 
    {
        $sql = 'select * from search_history where number=?';
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$number]);
        $result = $sth->fetchObject('App\Entity\PartsHistory');

        return $result ?: new PartsHistory();
    }
    
    
    
    public function getPartsHistory($id): PartsHistory 
    {
        $sql = 'select * from search_history where id=?';
        
        
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$id]);
        $result = $sth->fetchObject('App\Entity\PartsHistory');
        
        return $result ?: new PartsHistory();
    }
    
    
    
    public function storePartsHistory(PartsHistory $partsHistoryObj): PartsHistory 
    {
        if ($partsHistoryObj->getId()){
            $lastIncrement = $partsHistoryObj->getId();
            $sql = 'update search_history set request=?,updateDate=? where id=?';
            $sth = Core_static::getPDOStatement($sql);
            $sth->execute([$partsHistoryObj->getRequest(),$partsHistoryObj->getUpdate(),$partsHistoryObj->getId()]);
        } else {
            
            $sql = 'insert into search_history (number,request,updateDate) values(?,?,?)';
            $sth = Core_static::getPDOStatement($sql);
            $sth->execute([$partsHistoryObj->getNumber(), $partsHistoryObj->getRequest(), $partsHistoryObj->getUpdate()]);
            $lastIncrement = $this->dbh->lastInsertId();
        }
        
        
        return $this->getPartsHistory($lastIncrement);
    }
    
    
    
    public function getPartsByBrand($brandId,$page = null) 
    {
        $sql = 'select';
    }
    
  
    
    
    public function getPart($partId): Parts 
    {
        if (!isset($this->part[$partId])){
            $sql = 'select * from parts_number where id=?';
            $sth = Core_static::getPDOStatement($sql);
            $sth->execute([$partId]);
            $result = $sth->fetchObject('App\Entity\Parts')?: new Parts();
        
            $result->setBrand($this->getBrand($result->getBrandId()));
            $this->part[$partId] = $result;
        }
        
        
        return $this->part[$partId];
    }
    
    
    
    
    public function getBrand($brandId): Brand 
    {
        if (!isset($this->brand[$brandId])){
            $sql = 'select * from parts_brand where id=?';
            $sth = Core_static::getPDOStatement($sql);
            $sth->execute([$brandId]);
            $this->brand[$brandId] = $sth->fetchObject('App\Entity\Brand')?: new Brand();
            
        }
        
        
        return $this->brand[$brandId];
    }
    
    
    
    public function getUserPart($userPartsId): UserParts
    {
        $sql = 'select * from user_parts where id=?';
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$userPartsId]);
        $result = $sth->fetchObject('App\Entity\UserParts')?: new UserParts;
        
        $result->setParts($this->getPart($result->getPartsId()));
        
        return $result ;
    }
    
    
    
    
    public function getBrandByName($brand): Brand 
    {
        $sql = 'select * from parts_brand where name=?';
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$brand]);
        $result = $sth->fetchObject('App\Entity\Brand');
        
        return $result ?: new Brand;
    }
    
    
    public function storeBrand(Brand $brand): Brand 
    {
        if ($brand->getId()){
            $brandId = $brand->getId();
            $sql = 'update parts_brand set name=?,uuid=?,pId,? where id=?';
            $sth = Core_static::getPDOStatement($sql);
            $sth->execute([$brand->getName(), $brand->getUuid(), $brand->getParentId(), $brand->getId(), ]);
        } else {
            $sql = 'insert into parts_brand (name,uuid,pId) values(?,?,?)';
            $sth = Core_static::getPDOStatement($sql);
            $sth->execute([$brand->getName(), $brand->getUuid(), $brand->getParentId(), ]);
            $brandId = $this->dbh->lastInsertId();
        }
        return $this->getBrand($brandId);
    }
    
    
    public function storePart(Parts $parts): Parts
    {
        if ($parts->getId()){
            $partId = $parts->getId();
            $sql = 'update parts_number set number=?,numberText=?,info=?,brandId=?,uuid=?,pId=? where id=?';
            $sth = Core_static::getPDOStatement($sql);
            $sth->execute([
                $parts->getNumber(),
                $parts->getNumberText(),
                $parts->getInfo(),
                $parts->getBrandId(),
                $parts->getUuid(),
                $parts->getParentId(),
                $partId,
            ]);
        } else {
            $sql = 'insert into parts_number (number,numberText,info,brandId,uuid,pId) values(?,?,?,?,?,?)';
            $sth = Core_static::getPDOStatement($sql);
            $sth->execute([
                $parts->getNumber(),
                $parts->getNumberText(),
                $parts->getInfo(),
                $parts->getBrandId(),
                $parts->getUuid(),
                $parts->getParentId(),
            ]);
            $partId = $this->dbh->lastInsertId();    
        }
        
        return $this->getPart($partId);
    }
    
    
    public function storeUserPart(UserParts $userParts): UserParts 
    {
        if ($userParts->getId()){
            
        } else {
            $sql = 'insert into user_parts (userId,partsId,price,property,info,comment,uuid) values(?,?,?,?,?,?,?)';
            $sth = Core_static::getPDOStatement($sql);
            $sth->execute([
                $userParts->getUserId(),
                $userParts->getPartsId(),
                $userParts->getPrice(),
                $userParts->getProperty(),
                $userParts->getInfo(),
                $userParts->getComment(),
                $userParts->getUuid(),
            ]);
            $userPartsId = $this->dbh->lastInsertId();    
        }
        
        return $this->getUserPart($userPartsId);
    }
    
    
    
    
    public function  getParts($brandId,$page = null)
    {
        
    }
    
    
    public function getUserParts($pageNumber, $userId) {
        
        $from = $pageNumber*20;
        $sql = 'select * from user_parts where userId=:userId order by id limit :from,20';
        $sth = Core_static::getPDOStatement($sql);
        $sth->bindParam(':from',$from,\PDO::PARAM_INT);
        $sth->bindParam(':userId',$userId,\PDO::PARAM_INT);
        
        $sth->execute();
        
        $resultUserParts = $sth->fetchAll(\PDO::FETCH_CLASS,'App\Entity\UserParts');
        
        if ($resultUserParts){
            foreach($resultUserParts as $userPart){
                $userPart->setParts($this->getPart($userPart->getPartsId()));
            }
        }
        
        return $resultUserParts;
    }
    
    
    public function getUserPartsNumberOfRecords($userId): int 
    {
        $sql = 'select count(id) from userParts where userId=:userId';
        $sth = Core_static::getPDOStatement($sql);
        $sth->bindParam(':userId',$userId,\PDO::PARAM_INT);
        return $sth->fetchColumn();
    }
    
    
    
    
    public function getUserPartsByPart($partId) 
    {
        $sql = 'select * from user_parts where partsId=?';
        $sth = Core_static::getPDOStatement($sql);

        $sth->execute([$partId]);
        
        $resultUserParts = $sth->fetchAll(\PDO::FETCH_CLASS,'App\Entity\UserParts');
        
        if ($resultUserParts){
            foreach($resultUserParts as $userPart){
                $userPart->setParts($this->getPart($userPart->getPartsId()));
                $userPart->setUser($this->userRep->get($userPart->getUserId()));
            }
        }
        
        return $resultUserParts;
    }
    
    
    
}
