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
    
    //helper methods
    public function getTypeHandle()
    {
        return $this->getEntity()->getTypeHandle();
    }
    
    public function getDisplayName()
    {
        return $this->getEntity()->getDisplayName();
    }
    
    public function getPrimaryEmail()
    {
        //TODO mz: should we move this into type instance? how to make this 'type-contributing'?
        $typeInstance = $this->getTypeInstance();
        switch($this->getTypeHandle()) {
            case 'individual':
            case 'company':
                $ret = 'N/A';
                break;
            default:
                throw new \Exception("How can I retrieve email for type '{$this->getTypeHandle()}'?");
        }
        
        return $ret;
    }
    
    public function getPrimaryPhone()
    {
        //TODO mz: should we move this into type instance? how to make this 'type-contributing'?
        $typeInstance = $this->getTypeInstance();
        switch($this->getTypeHandle()) {
            case 'individual':
            case 'company':
                $ret = 'N/A';
                break;
            default:
                throw new \Exception("How can I retrieve phone for type '{$this->getTypeHandle()}'?");
        }
        
        return $ret;
    }

}