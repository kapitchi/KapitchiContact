<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiContact\Entity;

use KapitchiBase\InputFilter\EventManagerAwareInputFilter;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class ContactInputFilter extends EventManagerAwareInputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'       => 'id',
            'required'   => false,
        ));
        $this->add(array(
            'name'       => 'identityId',
            'required'   => false,
            'filters'   => array(
                array('name' => 'Null'),
            ),
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
        
//        
//        $names = $typeManager->getCanonicalNames();
//        foreach($names as $name) {
//            $type = $typeManager->get($name);
//            $form = $type->getForm();
//            $inputFilter = $form->getInputFilter();
//            $this->add($inputFilter, $name);
//        }
    }
    
    /**
     * @return array 
     */
//    public function getValidationGroup() {
//        if($this->validationGroup === null) {
//            $this->validationGroup = array('id', 'identityId', 'typeHandle', 'displayName');
//        }
//        return $this->validationGroup;
//    }
//    
//    protected function attachDefaultListeners() {
//        parent::attachDefaultListeners();
//        $instance = $this;
//        $this->getEventManager()->attach('isValid.pre', function($e) use ($instance) {
//            $validationGroup = $instance->getValidationGroup();
//            //mz: sets validation group according typeHandle selected
//            $typeHandle = $instance->getValue('typeHandle');
//            if(!empty($typeHandle)) {
//                $validationGroup[] = $typeHandle;
//            }
//            
//            $instance->setValidationGroup($validationGroup);
//        });
//    }
    
}