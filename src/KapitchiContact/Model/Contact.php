<?php
namespace KapitchiContact\Model;

use KapitchiEntity\Model\GenericEntityModel;

class Contact extends GenericEntityModel
{
    protected $typeInstance;
    protected $type;
    
    public function getTypeInstance()
    {
        return $this->typeInstance;
    }

    public function setTypeInstance($typeInstance)
    {
        $this->typeInstance = $typeInstance;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

}