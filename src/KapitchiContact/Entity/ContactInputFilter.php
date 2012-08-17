<?php
namespace KapitchiContact\Entity;

use KapitchiBase\InputFilter\EventManagerAwareInputFilter;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class ContactInputFilter extends EventManagerAwareInputFilter
{
    protected $typeManager;
    
    public function __construct($typeManager)
    {
        $this->setTypeManager($typeManager);
        
        $this->add(array(
            'name'       => 'id',
            'required'   => false,
        ));
        $this->add(array(
            'name'       => 'identityId',
            'required'   => false,
        ));
        $this->add(array(
            'name'       => 'typeHandle',
            'required'   => true,
            'allow_empty' => false,
        ));
        
        $this->add(array(
            'name'       => 'displayName',
            'required'   => true,
            'validators' => array(
                /*array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),*/
            ),
            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        ));
        
        $names = $typeManager->getCanonicalNames();
        foreach($names as $name) {
            $type = $typeManager->get($name);
            $form = $type->getForm();
            $inputFilter = $form->getInputFilter();
            $this->add($inputFilter, $name);
        }
    }
    
    protected function attachDefaultListeners() {
        parent::attachDefaultListeners();
        $instance = $this;
        $this->getEventManager()->attach('isValid.pre', function($e) use ($instance) {
            $validationGroup = array('id', 'identityId', 'typeHandle', 'displayName');
            
            //mz: sets validation group according typeHandle selected
            $typeHandle = $instance->getValue('typeHandle');
            if(!empty($typeHandle)) {
                $validationGroup[] = $typeHandle;
            }
            
            $instance->setValidationGroup($validationGroup);
        });
    }
    
    public function getTypeManager()
    {
        return $this->typeManager;
    }

    public function setTypeManager($typeManager)
    {
        $this->typeManager = $typeManager;
    }

}