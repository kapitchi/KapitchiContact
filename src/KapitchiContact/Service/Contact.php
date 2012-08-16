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
            //TODO mz: What should I do with this? should contact types be implemented using mappers only?
            $typeManager = $instance->getTypeManager();
            $data = $e->getParam('data');
            $typeHandle = $e->getParam('entity')->getTypeHandle();
            $type = $typeManager->get($typeHandle);
            $persistData = $data[$typeHandle];
            $typeEntity = $type->getEntityService()->createEntityFromArray($persistData);
            $typeEntity->setContactId($e->getParam('entity')->getId());
            $type->getEntityService()->persist($typeEntity);
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