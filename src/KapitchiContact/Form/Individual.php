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
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => $this->translate('ID'),
            ),
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' => 'givenName',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Given name'),
            ),
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' => 'middleName',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Middle name'),
            ),
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' => 'familyName',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Family name'),
            ),
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' => 'maidenName',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Maiden name'),
            ),
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' => 'honorificPrefix',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Honorific prefix'),
            ),
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' => 'honorificSuffix',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Honorific suffix'),
            ),
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' => 'dob',
            'type' => 'Zend\Form\Element\Date',
            'options' => array(
                'label' => $this->translate('Date of birth'),
            ),
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' => 'personalId',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Personal ID'),
            ),
            'attributes' => array(
            ),
        ));
        
    }
    
}