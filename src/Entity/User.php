<?php
namespace App\Entity;

class User {
    protected $name;
    protected $nickName;
    protected $passwd;
    protected $email;
    protected $phone;
    protected $phoneCanonical;
    protected $telegramId;
    protected $keyMd5;
    protected $id;
    
    
    
    public function getPhoneCanonical() {
        return $this->phoneCanonical;
    }

    public function getTelegramId() {
        return $this->telegramId;
    }

        
    
    public function getId() {
        return $this->id;
    }

        public function getName() {
        return $this->name;
    }

    public function getNickName() {
        return $this->nickName;
    }

    public function getPasswd() {
        return $this->passwd;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getKey() {
        return $this->keyMd5;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setNickName($nickName): void {
        $this->nickName = $nickName;
    }

    public function setPasswd($passwd): void {
        $this->passwd = $passwd;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setPhone($phone): void {
        $this->phone = $phone;
    }

    public function setKey($key): void {
        $this->keyMd5 = $key;
    }
    
    public function setId($id): void {
        $this->id = $id;
    }

    public function setPhoneCanonical($phoneCanonical): void {
        $this->phoneCanonical = $phoneCanonical;
    }

    public function setTelegramId($telegramId): void {
        $this->telegramId = $telegramId;
    }



}
