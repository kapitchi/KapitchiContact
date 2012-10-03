<?php
namespace KapitchiContact\View\Helper;

use KapitchiEntity\View\Helper\AbstractEntityHelper;

class Contact extends AbstractEntityHelper
{
    public function getDisplayName($id) {
        $entity = $this->getEntityService()->find($id);
        if(!$entity) {
            return $this->getView()->translate('N/A');
        }
        return $entity->getDisplayName();
    }
    
}