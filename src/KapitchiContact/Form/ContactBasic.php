<?php

namespace KapitchiContact\Form;

use ZfcBase\Form\Form,
    Zend\Form\SubForm;

class ContactBasic extends Form {
    
    public function init() {
        $this->addElement('hidden', 'id');
        
        //name
        $nameSubForm = new SubForm();
        $nameSubForm->addElement('text', 'givenName', array(
            'label' => 'First name'
        ));
        $nameSubForm->addElement('text', 'familyName', array(
            'label' => 'Surname'
        ));
        
        $this->addSubForm($nameSubForm, 'name');
        
    }
}