<?php
namespace KapitchiContact\ContactType;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Individual extends AbstractEntityContactType
{
    public function getName()
    {
        return 'Individual';
    }
    
    public function findByContactId($contactId)
    {
        return $this->getEntityService()->findOneBy(array(
            'contactId' => $contactId
        ));
    }

}