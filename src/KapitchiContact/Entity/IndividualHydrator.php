<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiContact\Entity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class IndividualHydrator extends \Zend\Stdlib\Hydrator\ClassMethods
{
    public function extract($object) {
        $data = parent::extract($object);
        if($data['dob'] instanceof \DateTime) {
            $data['dob'] = $data['dob']->format('Y-m-d');//UTC
        }
        
        return $data;
    }

    public function hydrate(array $data, $object) {
        if(!empty($data['dob']) && !$data['dob'] instanceof \DateTime) {
            $data['dob'] = new \DateTime($data['dob']);
        }
        return parent::hydrate($data, $object);
    }
}