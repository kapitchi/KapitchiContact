<?php
namespace KapitchiContact\ContactType;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Company extends AbstractContactType
{
    
    public function findByContactId($contactId)
    {
        return $this->getTypeService()->findOneBy(array(
            'contactId' => $contactId
        ));
    }
    
}