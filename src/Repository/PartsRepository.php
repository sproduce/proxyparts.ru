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
    public function __construct()
    {
        $this->dbh = Core_static::loadPdo();
    }
    
    
    
    
    public function search($number) //return readModel[]
    {
        $sql = 'select pn.id,
                       pn.number, 
                       pn.numberText, 
                       pn.info,
                       pn.uuid,
                       pn.brandId,
                       pb.name,
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
    
    
    
    public function searchPart($number, Brand $brand): Parts 
    {
        $sql = 'select * from parts_number where number=? and brandId=?';
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$number,$brand->getId()]);
        $partsObj = $sth->fetchObject('App\Entity\Parts')?: new Parts();
        $partsObj->setBrand($brand);
        if ($partsObj->getParentId()){
            $partsObj->setParent($this->getPart($partsObj->getParentId()));
        }
        return $partsObj;
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
    
    public function searchParts($number) 
    {
        $sql = 'select * from parts_number where number=?';
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$number]);
        $result = $sth->fetchAll(\PDO::FETCH_CLASS,'App\Entity\Parts');
        
    }
    
    
    public function getPart($partId): Parts 
    {
        $sql = 'select * from parts_number where id=?';
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$partId]);
        $result = $sth->fetchObject('App\Entity\Parts')?: new Parts();
        
        $result->setBrand($this->getBrand($result->getBrandId()));
        
        return $result;
    }
    
    
    
    
    public function getBrand($brandId): Brand 
    {
        $sql = 'select * from parts_brand where id=?';
        $sth = Core_static::getPDOStatement($sql);
        $sth->execute([$brandId]);
        $result = $sth->fetchObject('App\Entity\Brand');
        
        return $result ?: new Brand;
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
    
    
    
}
