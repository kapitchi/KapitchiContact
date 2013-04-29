<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiContact\Service;

use KapitchiEntity\Service\EntityService,
    KapitchiEntity\Model\EntityModelInterface;

class Storage extends EntityService
{
    public function fetchPrimary($contact, $handle)
    {
        //TODO
        $contactId = $contact;
        $paginator = $this->getPaginator(array('contactId' => $contactId, 'handle' => $handle), array('priority DESC'));
        
        $paginator->setCurrentPageNumber(1);
        $paginator->setItemCountPerPage(1);
        $items = $paginator->getCurrentItems();
        return current($items);
    }
    
    public function fetchPrimaryValue($contact, $handle)
    {
        $data = $this->fetchPrimary($contact, $handle);
        if($data) {
            return $data->getValue();
        }
        
        return null;
    }
    
    public function findContactIdByHandleValue($handle, $value)
    {
        $entity = $this->findOneBy(array(
            'handle' => $handle,
            'value' => $value
        ));
        
        if($entity) {
            return $entity->getContactId();
        }
        
        return null;
    }
    
    public function fetchData($contactId, $handle) {
        $all = $this->fetchAll(array(
            'contactId' => $contactId,
            'handle' => $handle,
        ), array('priority DESC'));
        
        $ret = array();
        foreach($all as $rec) {
            $ret[$rec->getTag()] = array(
                'value' => $rec->getValue(),
                'priority' => $rec->getPriority(),
                'tag' => $rec->getTag(),
            );
        }
        
        return $ret;
    }
    
    /**
     * This method removes all storage records first for contactId and handle
     * and then inserts all the values from $data param.
     * 
     * $data in format:
     * array(
     *     'value' => 'email@example.com',
     *     'tag' => 'work',//optional - defaults to 'default'
     *     'priority' => 1, //optional
     * )
     * 
     * @param int $contactId
     * @param string $handle
     * @param array $data
     * @return array \KapitchiContact\Entity\Storage[]
     */
    public function persistData($contactId, $handle, array $data)
    {
        $ret = array();
        $tags = array();
        $prio = 0;
        foreach($data as $rec) {
            $tag = empty($rec['tag']) ? 'default' : $rec['tag'];
            
            if(in_array($tag, $tags)) {
                throw new \InvalidArgumentException("Same tag used on multiple values");
            }
            $tags[] = $tag;
            
            $entity = $this->createEntityFromArray(array(
                'contactId' => $contactId,
                'handle' => $handle,
                'value' => empty($rec['value']) ? '' : $rec['value'],
                'priority' => empty($rec['priority']) ? $prio-- : $rec['priority'],
                'tag' => $tag,
            ));
            $ret[] = $entity;
        }
        
        $mapper = $this->getMapper();
        $adapter = $this->getMapper()->getPaginatorAdapter(array(
            'contactId' => $contactId,
            'handle' => $handle,
        ));
        foreach($adapter->getItems(0, (int)$adapter->count()) as $entity) {
            $mapper->remove($entity);
        }
        foreach($ret as $entity) {
            $mapper->persist($entity);
        }
        
        return $ret;
    }
    
}