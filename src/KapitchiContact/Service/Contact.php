<?php
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