<?php
namespace App\Repository\Interfaces;

use App\Entity\User;


interface UserRepositoryInterface {
    public function get($userId): User;
    public function getUserByEmail($email): User;
    public function isPhoneExist(User $userObj): bool;
    public function isEmailExist(User $userObj): bool;
    
    public function store(User $userObj): User;
    
}
