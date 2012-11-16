<?php
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
    
    public function fetchData($contactId, $handle) {
        $all = $this->fetchAll(array(
            'contactId' => $contactId,
            'handle' => $handle,
        ), array('priority DESC'));
        
        $ret = array();
        foreach($all as $rec) {
            $ret[$rec->getTag()] = $rec->getValue();
        }
        
        return $ret;
    }
    
    public function persistData($contactId, $handle, $data)
    {
        $mapper = $this->getMapper();
        $adapter = $this->getMapper()->getPaginatorAdapter(array(
            'contactId' => $contactId,
            'handle' => $handle,
        ));
        foreach($adapter->getItems(0, $adapter->count()) as $entity) {
            $mapper->remove($entity);
        }
        
        $ret = array();
        $prio = 0;
        foreach($data as $rec) {
            $entity = $this->createEntityFromArray(array(
                'contactId' => $contactId,
                'handle' => $handle,
                'value' => empty($rec['value']) ? '' : $rec['value'],
                'priority' => empty($rec['priority']) ? $prio-- : $rec['priority'],
                'tag' => empty($rec['tag']) ? 'default' : $rec['tag'],
            ));
            $mapper->persist($entity);
            $ret[] = $entity;
        }
        
        return $ret;
    }
    
}