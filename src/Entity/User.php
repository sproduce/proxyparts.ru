<?php
namespace App\Entity;

class User {
    protected $name;
    protected $nickName;
    protected $passwd;
    protected $passwdRepeat;
    protected $email;
    protected $phone;
    protected $key;
    
    
    
    public function getName() {
        return $this->name;
    }

    public function getNickName() {
        return $this->nickName;
    }

    public function getPasswd() {
        return $this->passwd;
    }

    public function getPasswdRepeat() {
        return $this->passwdRepeat;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getKey() {
        return $this->key;
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

    public function setPasswdRepeat($passwdRepeat): void {
        $this->passwdRepeat = $passwdRepeat;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setPhone($phone): void {
        $this->phone = $phone;
    }

    public function setKey($key): void {
        $this->key = $key;
    }


}
