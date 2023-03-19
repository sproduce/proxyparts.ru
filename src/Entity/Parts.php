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
    protected Brand $brand;
    

}
