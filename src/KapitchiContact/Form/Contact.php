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
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => 'ID',
            ),
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' => 'identityId',
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => 'Identity ID',
            ),
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name' => 'typeHandle',
            'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                'label' => 'Type',
            ),
            'attributes' => array(
                'options' => $typeHandleOptions
            ),
        ));
        
        $this->add(array(
            'name' => 'displayName',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Display name',
            ),
            'attributes' => array(
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