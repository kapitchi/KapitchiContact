<?php

namespace KapitchiContact\Form;

use Zend\Form\Form,
    Zend\Form\SubForm;

class Contact extends Form {
    
    public function init() {
        $this->addElement('hidden', 'id');
        
        //name
        $nameSubForm = new Form();
        $nameSubForm->addElement('text', 'formatted', array(
            'label' => 'Formatted name',
            'readonly' => true
        ));
        $nameSubForm->addElement('text', 'givenName', array(
            'label' => 'First name'
        ));
        $nameSubForm->addElement('text', 'middleName', array(
            'label' => 'Middle name'
        ));
        $nameSubForm->addElement('text', 'familyName', array(
            'label' => 'Surname'
        ));
        $nameSubForm->addElement('text', 'honorificPrefix', array(
            'label' => 'Prefix'
        ));
        $nameSubForm->addElement('text', 'honorificSuffix', array(
            'label' => 'Suffix'
        ));
        
        $this->addSubForm($nameSubForm, 'name');
        
        //phoneNumbers
        $phoneNumberSubForm = new SubForm();
        foreach(array(
            'mobile' => 'Mobile number',
            'work' => 'Work number',
            'home' => 'Home number') as $type => $numberLabel) {
            $phoneNumberTypeForm = new SubForm();
//            $phoneNumberTypeForm->addElement('hidden', 'type', array(
//                'label' => 'Type'
//            ));
            $phoneNumberTypeForm->addElement('checkbox', 'primary', array(
                'label' => 'Primary'
            ));
            $phoneNumberTypeForm->addElement('text', 'value', array(
                'label' => $numberLabel
            ));
            
            $phoneNumberSubForm->addSubForm($phoneNumberTypeForm, $type);
        }
        $this->addSubForm($phoneNumberSubForm, 'phoneNumbers');
        
        //emails
        $emailsSubForm = new SubForm();
        foreach(array(
            'personal' => 'Personal email',
            'work' => 'Work email') as $type => $emailLabel) {
            $typeForm = new SubForm();
            //$typeForm->addElement('select', 'type');
            $typeForm->addElement('checkbox', 'primary', array(
                'label' => 'Primary'
            ));
            $typeForm->addElement('text', 'value', array(
                'label' => $emailLabel
            ));
            
            $emailsSubForm->addSubForm($typeForm, $type);
        }
        $this->addSubForm($emailsSubForm, 'emails');
        
        
    }
}