<?php
namespace App\Repository;

use App\Repository\Interfaces\PartsRepositoryInterface;
use App\Entity\PartsHistory;
use App\Lib\Core_static;

use App\Entity\Brand;
use App\Entity\Parts;


class PartsRepository implements PartsRepositoryInterface
{
    private $dbh;
    public function __construct()
    {
        $this->dbh = Core_static::loadPdo();
    }
    
    
    
    
    public function search($number) 
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
    
    
    public function getPart($partId): Parts 
    {
        $sql = 'select  parts_number_id as id,
                        parts_number as number,
                        parts_number_text as numberText
                        parts_number_parts_brand_id as brandId,
                        parts_number_info as info
                        parts_number_uuid as uuid,
                        parts_number_pId as pId';
        
        
        
        
        
        
    }
    
    
    
    
    public function getBrand($brandId): Brand 
    {
        $sql = 'select parts_brand_id as id,
                       parts_brand_name as name,
                       parts_brand_uuid	as uuid,
                       parts_brand_pId as pid	
                where parts_brand_id=?';
    }
    
    
    
    public function getBrandByName($brand): Brand 
    {
        $sql = 'select parts_brand_id as id,
                       parts_brand_name as name,
                       parts_brand_uuid	as uuid,
                       parts_brand_pId as pid	
                where parts_brand_name=?';
    }
    
    
    
}
