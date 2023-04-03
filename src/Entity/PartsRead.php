<?php
namespace App\Entity;



class PartsRead
{
    protected $id;
    protected $uuid;
    protected $number;
    protected $numberText;
    protected $info;
    protected $brand;
    protected $brandId;
    
    public function getId() {
        return $this->id;
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

    public function getBrand() {
        return $this->brand;
    }

    public function getBrandId() {
        return $this->brandId;
    }

    public function setId($id): void {
        $this->id = $id;
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

    public function setBrand($brand): void {
        $this->brand = $brand;
    }

    public function setBrandId($brandId): void {
        $this->brandId = $brandId;
    }

}
