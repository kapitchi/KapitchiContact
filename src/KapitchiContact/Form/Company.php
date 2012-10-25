<?php

namespace KapitchiContact\Form;

use KapitchiBase\Form\EventManagerAwareForm;

class Company extends EventManagerAwareForm
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setLabel('Company');
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
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Company name',
            ),
            'attributes' => array(
                
            ),
            
        ));
        
        $this->add(array(
            'name' => 'primaryContactId',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Primary contact',
            ),
            'attributes' => array(
                'data-kap-ui' => 'contact-lookup-input',
            ),
            
        ));
        
    }
    
}