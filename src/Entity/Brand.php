<?php
namespace App\Entity;

class Brand
{
    protected $id;
    protected $uuid;
    protected $name;
    protected $parentId;
    protected Brand $parent;
    
    
    public function getId() {
        return $this->id;
    }

    public function getUuid() {
        return $this->uuid;
    }

    public function getName() {
        return $this->name;
    }

    public function getParentId() {
        return $this->parentId;
    }

    public function getParent(): Brand {
        return $this->parent;
    }


    public function setId($id): void {
        $this->id = $id;
    }

    public function setUuid($uuid): void {
        $this->uuid = $uuid;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setParentId($parentId): void {
        $this->parentId = $parentId;
    }

    public function setParent(Brand $parent): void {
        $this->parent = $parent;
    }


    
    
    

}
