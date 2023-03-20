<?php
namespace App\Entity;




class PartsHistory
{
    protected $id=null;
    protected $number;
    protected $request=0;
    protected $update;

    
    public function getId() {
        return $this->id;
    }

    public function getNumber() {
        return $this->number;
    }
    
    public function getRequest() {
        return $this->request;
    }

    public function getUpdate() {
        return $this->update;
    }


    public function setId($id): void {
        $this->id = $id;
    }

    public function setNumber($number): void {
        $this->number = $number;
    }

    public function setRequest($request): void {
        $this->request = $request;
    }

    public function setUpdate($update): void {
        $this->update = $update;
    }



}
