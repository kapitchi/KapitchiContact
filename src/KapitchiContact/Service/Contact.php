<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiContact\Service;

use KapitchiEntity\Service\EntityService,
    KapitchiEntity\Model\EntityModelInterface;

class Contact extends EntityService
{
    protected $storageService;
    
    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        $em = $this->getEventManager();
        $em->attach('persist', function($e) {
            $service = $e->getTarget()->getStorageService();
            $entity = $e->getParam('entity');
            $data = $e->getParam('data');
            
            //TODO XXX mz: we do this in app plugin KapitchiContact
//            if($data && isset($data['emails'])) {
//                $service->persistData($entity->getId(), 'email', $data['emails']);
//            }
        });
    }
    
    public function getStorageService()
    {
        return $this->storageService;
    }

    public function setStorageService($storageService)
    {
        $this->storageService = $storageService;
    }

}