<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

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
                //'data-kap-ui' => 'identity-lookup-input'
            ),
        ), array(
            'priority' => -100,
        ));
        
        $this->add(array(
            'name' => 'typeHandle',
            'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                'label' => $this->translate('Contact type'),
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
        
        $this->add(array(
            'name' => 'note',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => $this->translate('Note'),
            ),
        ), array(
            'priority' => -1000,
        ));
    }
    
}