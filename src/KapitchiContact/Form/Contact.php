<?php

namespace KapitchiContact\Form;

use KapitchiBase\Form\EventManagerAwareForm;

class Contact extends EventManagerAwareForm
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        
        $this->setLabel('Contact');
        
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
    
}