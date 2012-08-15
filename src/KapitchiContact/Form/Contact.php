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
        $this->add(array(
            'name' => 'displayName',
            'options' => array(
                'label' => 'Display name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
        $names = $typeManager->getCanonicalNames();
        foreach($names as $name) {
            $type = $typeManager->get($name);
            $form = $type->getForm('contact');
            $this->add($form);
        }
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