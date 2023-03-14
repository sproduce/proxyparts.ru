<?php
namespace App\Repository\Interfaces;

use App\Entity\User;


interface UserRepositoryInterface {
    public function get($userId): User;
    public function isPhoneExist(User $userObj): bool;
    public function update(User $userObj): User;
    public function add(User $userObj): User;
    
    
}
