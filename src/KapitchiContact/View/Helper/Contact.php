<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

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