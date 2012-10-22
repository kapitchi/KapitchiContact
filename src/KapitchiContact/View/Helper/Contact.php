<?php
namespace KapitchiContact\View\Helper;

use KapitchiEntity\View\Helper\AbstractEntityHelper;

class Contact extends AbstractEntityHelper
{
    public function getDisplayName($entity = null) {
        $entity = $this->fetchEntity($entity);
        if(!empty($entity)) {
            return $entity->getDisplayName();
        }
            
        return $this->getView()->translate('N/A');
    }
    
    public function getPrimaryEmail($entity = null)
    {
        $entity = $this->fetchEntity($entity);
        if(!empty($entity)) {
            $value = $this->getEntityService()->getFieldValues($entity, 'primaryEmail');
        }
        
        return empty($value) ? $this->getView()->translate('N/A') : $value;
    }
    
    public function getPrimaryPhone($entity = null)
    {
        $entity = $this->fetchEntity($entity);
        if(!empty($entity)) {
            $value = $this->getEntityService()->getFieldValues($entity, 'primaryPhone');
        }
            
        return empty($value) ? $this->getView()->translate('N/A') : $value;
    }
}