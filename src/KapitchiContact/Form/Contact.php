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
                'label' => $this->translate('ID'),
            ),
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' => 'identityId',
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => $this->translate('Identity'),
            ),
            'attributes' => array(
                'data-kap-ui' => 'identity-lookup-input'
            ),
        ), array(
            'priority' => -100,
        ));
        
        $this->add(array(
            'name' => 'typeHandle',
            'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                'label' => $this->translate('Type'),
            ),
            'attributes' => array(
                
            ),
        ));
        
        $this->add(array(
            'name' => 'displayName',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Display name'),
            ),
            'attributes' => array(
                
            ),
        ));
        
    }
    
}