<?php
namespace KapitchiContact\Form;

use KapitchiBase\Form\EventManagerAwareForm;

class ContactAddress extends EventManagerAwareForm
{
    
    public function __construct($name = null)
    {
        parent::__construct($name);
        
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => $this->translate('ID'),
            ),
        ));
        
        $this->add(array(
            'name' => 'contactId',
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => $this->translate('Contact'),
            ),
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name' => 'typeHandle',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => $this->translate('Address type'),
                'value_options' => array(
                    'default' => $this->translate('Default')
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'addressId',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Address'),
            ),
            'attributes' => array(
                'data-kap-ui' => 'address-lookup-input',
            ),
        ));
        
    }
    
    /**
     * 
     * @return \KapitchiContact\ContactType\ContactTypeManager
     */
    public function getTypeManager()
    {
        return $this->typeManager;
    }

    public function setTypeManager($typeManager)
    {
        $this->typeManager = $typeManager;
    }

}