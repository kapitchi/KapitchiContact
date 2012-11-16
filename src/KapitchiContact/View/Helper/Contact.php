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
    
}