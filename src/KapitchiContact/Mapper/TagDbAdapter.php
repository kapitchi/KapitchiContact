<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiContact\Mapper;

use KapitchiEntity\Mapper\EntityDbAdapterMapper;

class TagDbAdapter extends EntityDbAdapterMapper {
    protected $contactTagTableName = 'contact_contact_tag';
    
    public function addContactTag($contactId, $tagId)
    {
        $this->getTableGateway($this->contactTagTableName, true)->insert(array(
            'contactId' => $contactId,
            'tagId' => $tagId,
        ));
    }
            
    public function getPaginatorAdapter(array $criteria = null, array $orderBy = null)
    {
        $select = $this->select();
        $select->from($this->getTableName());
        
        if(isset($criteria['contactId'])) {
            $select->join('contact_contact_tag', 'contact_contact_tag.tagId = contact_tag.id', array());
        }
        
        $this->initPaginatorSelect($select, $criteria, $orderBy);
        return $this->createPaginatorAdapter($select);
    }
    
}