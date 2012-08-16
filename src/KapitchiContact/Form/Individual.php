<?php

namespace KapitchiContact\Form;

use KapitchiBase\Form\EventManagerAwareForm;

class Individual extends EventManagerAwareForm
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setLabel('Individual');
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
            'name' => 'givenName',
            'options' => array(
                'label' => 'Given name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'middleName',
            'options' => array(
                'label' => 'Middle name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'familyName',
            'options' => array(
                'label' => 'Family name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'maidenName',
            'options' => array(
                'label' => 'Maiden name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'honorificPrefix',
            'options' => array(
                'label' => 'Honorific prefix',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'honorificSuffix',
            'options' => array(
                'label' => 'Honorific suffix',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'dob',
            'options' => array(
                'label' => 'Date of birth',
            ),
            'attributes' => array(
                'type' => 'date'
            ),
        ));
        $this->add(array(
            'name' => 'personalId',
            'options' => array(
                'label' => 'Personal ID',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
    }
    
}