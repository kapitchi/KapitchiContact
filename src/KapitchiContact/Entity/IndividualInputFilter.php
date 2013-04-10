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
class IndividualInputFilter extends EventManagerAwareInputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'       => 'id',
            'required'   => false,
        ));
        $this->add(array(
            'name'       => 'contactId',
            'required'   => false,
        ));
        $this->add(array(
            'name'       => 'givenName',
            'required'   => true,
        ));
        $this->add(array(
            'name'       => 'middleName',
            'required'   => false,
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