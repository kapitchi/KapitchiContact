<?php
namespace KapitchiContact\Entity;

use KapitchiBase\InputFilter\EventManagerAwareInputFilter;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class IndividualInputFilter extends EventManagerAwareInputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'       => 'givenName',
            'required'   => true,
        ));
        $this->add(array(
            'name'       => 'middleName',
            'required'   => true,
        ));
        $this->add(array(
            'name'       => 'familyName',
            'required'   => true,
        ));
        $this->add(array(
            'name'       => 'maidenName',
            'required'   => false,
        ));
        $this->add(array(
            'name'       => 'honorificPrefix',
            'required'   => false,
        ));
        $this->add(array(
            'name'       => 'dob',
            'required'   => false,
        ));
        $this->add(array(
            'name'       => 'personalId',
            'required'   => false,
        ));
        
    }
}