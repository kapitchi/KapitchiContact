<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */


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
                'label' => $this->translate('ID'),
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Company name'),
            ),
        ));
        
        $this->add(array(
            'name' => 'refNumber',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Company reference number'),
            ),
        ));
        
        $this->add(array(
            'name' => 'taxRefNumber',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Tax reference number'),
            ),
        ));
        
        $this->add(array(
            'name' => 'taxRegNumber',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Tax registration number'),
            ),
        ));
        
        $this->add(array(
            'name' => 'primaryContactId',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Primary contact'),
            ),
            'attributes' => array(
                'data-kap-ui' => 'contact-lookup-input',
            ),
            
        ));
        
    }
    
}