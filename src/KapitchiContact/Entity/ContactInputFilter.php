<?php
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
    }
}