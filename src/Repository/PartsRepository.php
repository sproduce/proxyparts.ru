<?php
namespace App\Repository;

use App\Repository\Interfaces\PartsRepositoryInterface;
use App\Entity\PartsHistory;


class PartsRepository implements PartsRepositoryInterface
{
    private $dbh;
    public function __construct()
    {
        $this->dbh = \Core_static::loadPdo();
    }
    
    
    
    
    public function search($number) 
    {
        $sql = "select pn.parts_number_id as id,
                       pn.parts_number as number, 
                       pn.parts_number_text as numberText, 
                       pn.parts_number_info as info,
                       pn.parts_number_uuid as uuid,
                       pb.parts_brand_id as brandId,
                       pb.parts_brand_name as brand,
                       pb.parts_brand_uuid as brandUuid
                from 
                       pp_parts_number as pn,pp_parts_brand as pb
                where
                       pb.parts_brand_id=pn.parts_number_parts_brand_id and
                       pn.parts_number=?";
        
        $sth = \Core_static::getPDOStatement($sql);
        $sth->execute([$number]);
        
        $result = $sth->fetchAll(\PDO::FETCH_CLASS,"App\Entity\PartsRead");
        
        return $result;
    }
    
    
    public function searchPartsHistory($number): PartsHistory 
    {
        $sql = "select search_history_id as id,
                       search_history_number as number,
                       search_history_request as request,
                       search_history_update as `update`
                from pp_search_history 
                where search_history_number=?";
        
        
        $sth = \Core_static::getPDOStatement($sql);
        $sth->execute([$number]);
        $result = $sth->fetchObject("App\Entity\PartsHistory");
        
        return $result ? $result : new PartsHistory();
    }
    
    
    
    public function getPartsHistory($id): PartsHistory 
    {
         $sql = "select search_history_id as id,
                       search_history_number as number,
                       search_history_request as request,
                       search_history_update as `update`
                from pp_search_history where search_history_id=?";
        
        
        $sth = \Core_static::getPDOStatement($sql);
        $sth->execute([$id]);
        $result = $sth->fetchObject("App\Entity\PartsHistory");
        
        return $result ?? new PartsHistory();
    }
    
    
    
    public function storePartsHistory(PartsHistory $partsHistoryObj): PartsHistory 
    {
        if ($partsHistoryObj->getId()){
            $lastIncrement = $partsHistoryObj->getId();
            $sql = "update pp_search_history set search_history_request=?,search_history_update=? where search_history_id=?";
            $sth = \Core_static::getPDOStatement($sql);
            $sth->execute([$partsHistoryObj->getRequest(),$partsHistoryObj->getUpdate(),$partsHistoryObj->getId()]);
        } else {
            $sql = "insert into pp_search_history (search_history_number,search_history_request,search_history_update) values(?,?,?)";
            $sth = \Core_static::getPDOStatement($sql);
            $sth->execute([$partsHistoryObj->getNumber(), $partsHistoryObj->getRequest(), $partsHistoryObj->getUpdate()]);
            $lastIncrement = $this->dbh->lastInsertId();
        }
        
        
        return $this->getPartsHistory($lastIncrement);
    }
    
    
    
    
    
    
}
