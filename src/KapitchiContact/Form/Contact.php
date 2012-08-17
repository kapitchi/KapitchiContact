<?php

namespace KapitchiContact\Form;

use KapitchiBase\Form\EventManagerAwareForm,
    Zend\Form\Form;

class Contact extends EventManagerAwareForm
{
    protected $typeManager;
    
    public function __construct($typeManager, $name = null)
    {
        parent::__construct($name);
        
        $this->setTypeManager($typeManager);
        
        $this->setLabel('Contact');
        
        $names = $typeManager->getCanonicalNames();
        $typeHandleOptions = array();
        foreach($names as $name) {
            $type = $typeManager->get($name);
            $typeHandleOptions[] = array(
                'value' => $name,
                'label' => $type->getName(),
            );
            $form = $type->getForm('contact');
            $this->add($form);
        }
        
        $this->add(array(
            'name' => 'id',
            'options' => array(
                'label' => 'ID',
            ),
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'identityId',
            'options' => array(
                'label' => 'Identity ID',
            ),
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        
        $this->add(array(
            'name' => 'typeHandle',
            'options' => array(
                'label' => 'Type',
            ),
            'attributes' => array(
                'type' => 'radio',
                'options' => $typeHandleOptions
            ),
        ));
        
        $this->add(array(
            'name' => 'displayName',
            'options' => array(
                'label' => 'Display name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
    }
    
    /**
     * 
     * @return \KapitchiContact\ContactType\ContactTypeManager
     */
    public function getTypeManager()
    {
        return $this->typeManager;
    }

    public function setTypeManager($typeManager)
    {
        $this->typeManager = $typeManager;
    }

}