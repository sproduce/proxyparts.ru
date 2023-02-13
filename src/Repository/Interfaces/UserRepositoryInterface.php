<?php
namespace App\Repository\Interfaces;

use App\Entity\User;


interface UserRepositoryInterface {
    public function getUser($iserId): User;
    
}
