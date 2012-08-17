<?php
namespace KapitchiContact\Entity;

use KapitchiBase\InputFilter\EventManagerAwareInputFilter;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class CompanyInputFilter extends EventManagerAwareInputFilter
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
            'name'       => 'name',
            'required'   => true,
        ));
    }
}