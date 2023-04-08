<?php
namespace App\Entity;
use App\Entity\Brand;



class Parts
{
    protected $id;
    protected $brandId;
    protected $uuid;
    protected $number;
    protected $numberText;
    protected $info;
    protected $parentId = null;
    protected Parts $parent;
    protected Brand $brand;
    
    
    public function getParentId() {
        return $this->parentId;
    }

    public function getParent(): Parts {
        return $this->parent;
    }

        
    public function getId() {
        return $this->id;
    }

    public function getBrandId() {
        return $this->brandId;
    }

    public function getUuid() {
        return $this->uuid;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getNumberText() {
        return $this->numberText;
    }

    public function getInfo() {
        return $this->info;
    }

    public function getBrand(): Brand {
        return $this->brand;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setBrandId($brandId): void {
        $this->brandId = $brandId;
    }

    public function setUuid($uuid): void {
        $this->uuid = $uuid;
    }

    public function setNumber($number): void {
        $this->number = $number;
    }

    public function setNumberText($numberText): void {
        $this->numberText = $numberText;
    }

    public function setInfo($info): void {
        $this->info = $info;
    }

    public function setBrand(Brand $brand): void {
        $this->brand = $brand;
    }

    public function setParent(Parts $parent): void {
        $this->parent = $parent;
    }

    public function setParentId($parentId): void {
        $this->parentId = $parentId;
    }



}
