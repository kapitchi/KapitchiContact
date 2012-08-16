<?php
namespace KapitchiContact\ContactType;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Company extends AbstractEntityContactType
{
    
    public function getName()
    {
        return 'Company';
    }
    
    public function findByContactId($contactId)
    {
        return $this->getEntityService()->findOneBy(array(
            'contactId' => $contactId
        ));
    }

}