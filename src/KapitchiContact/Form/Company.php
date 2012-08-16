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
            'options' => array(
                'label' => 'ID',
            ),
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => 'Company name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
            
        ));
        
    }
    
}