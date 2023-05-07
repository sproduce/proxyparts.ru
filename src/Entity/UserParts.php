<?php
namespace App\Entity;

use App\Entity\User;
use App\Entity\Parts;



class UserParts
{
    protected $id;
    protected $userId;
    protected $partsId;
    protected $price;
    protected $property;
    protected $info;
    protected $comment;
    protected $uuid;
    protected User $user;
    protected Parts $parts;
  
    
    
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getPartsId() {
        return $this->partsId;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getProperty() {
        return $this->property;
    }

    public function getInfo() {
        return $this->info;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getUuid() {
        return $this->uuid;
    }

    public function getUser() {
        return $this->user;
    }

    public function getParts() {
        return $this->parts;
    }


    
    public function setId($id): void {
        $this->id = $id;
    }

    public function setUserId($userId): void {
        $this->userId = $userId;
    }

    public function setPartsId($partsId): void {
        $this->partsId = $partsId;
    }

    public function setPrice($price): void {
        $this->price = $price;
    }

    public function setProperty($property): void {
        $this->property = $property;
    }

    public function setInfo($info): void {
        $this->info = $info;
    }

    public function setComment($comment): void {
        $this->comment = $comment;
    }

    public function setUuid($uuid): void {
        $this->uuid = $uuid;
    }

    public function setUser(User $user): void {
        $this->userId = $user->getId();
        $this->user = $user;
    }

    public function setParts(Parts $parts): void {
        $this->partsId = $parts->getId();
        $this->parts = $parts;
    }


    
}
