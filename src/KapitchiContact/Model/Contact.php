<?php
namespace KapitchiContact\Model;

use KapitchiEntity\Model\GenericEntityModel;

class Contact extends GenericEntityModel
{
    protected $typeInstance;
    
    public function getTypeInstance()
    {
        return $this->typeInstance;
    }

    public function setTypeInstance($typeInstance)
    {
        $this->typeInstance = $typeInstance;
    }

}