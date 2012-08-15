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
            'name' => 'givenName',
            'options' => array(
                'label' => 'Given Name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'middleName',
            'options' => array(
                'label' => 'Middle Name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'familyName',
            'options' => array(
                'label' => 'Family Name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'maidenName',
            'options' => array(
                'label' => 'Maiden Name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'honorificPrefix',
            'options' => array(
                'label' => 'Honorific Prefix',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'honorificSuffix',
            'options' => array(
                'label' => 'Honorific Suffix',
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
                'type' => 'text'
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