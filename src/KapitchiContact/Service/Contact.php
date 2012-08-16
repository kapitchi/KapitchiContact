<?php
namespace KapitchiContact\Service;

use KapitchiEntity\Service\EntityService,
    KapitchiEntity\Model\EntityModelInterface,
    KapitchiContact\ContactType\ContactTypeManager;

class Contact extends EntityService
{
    protected $typeManager;
    
    public function loadModel($entity, $options = array(), EntityModelInterface $model = null)
    {
        $handle = $entity->getTypeHandle();
        $type = $this->getTypeManager()->get($handle);
        $typeInstance = $type->findByContactId($entity->getId());
        
        $model = new \KapitchiContact\Model\Contact();
        $model->setType($type);
        $model->setEntity($entity);
        $model->setTypeInstance($typeInstance);
        
        return parent::loadModel($entity, $options, $model);
    }
    
    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        
        $instance = $this;
        $this->getEventManager()->attach('persist', function($e) use ($instance) {
                    var_dump($e);
                    exit;
        });
    }
    
    public function getTypeManager()
    {
        return $this->typeManager;
    }

    public function setTypeManager(ContactTypeManager $typeManager)
    {
        $this->typeManager = $typeManager;
    }

}