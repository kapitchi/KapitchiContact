<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

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
        
        $currentYear = date("Y");
        $minYear = $currentYear - 100;
        $this->add(array(
            'name' => 'dob',
            'type' => 'Zend\Form\Element\Date',
            'options' => array(
                'label' => $this->translate('Date of birth'),
            ),
            'attributes' => array(
                'data-jquery-options' => json_encode(array(
                    'changeYear' => 1,
                    'yearRange' => "$minYear:$currentYear"
                ))
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