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
                'label' => 'ID',
            ),
        ));
        
        $this->add(array(
            'name' => 'contactId',
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => 'Contact ID',
            ),
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name' => 'addressId',
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => 'Address ID',
            ),
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name' => 'typeHandle',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Address type',
                'value_options' => array(
                    'default' => 'Default'
                ),
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