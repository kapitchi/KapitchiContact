<?php

namespace KapitchiContact\Model\Mapper;

use KapitchiContact\Model\Mapper\Contact as ContactMapper,
    KapitchiBase\Mapper\DbAdapterMapper,
        KapitchiContact\Model\Contact as ContactModel;

class ContactZendDb extends DbAdapterMapper implements ContactMapper {
    protected $tableName = 'contact';
    
    public function persist(ContactModel $contact) {
        
        return true;
    }
    
    public function findById($id) {
        $table = $this->getTableGateway($this->tableName);
        $result = $table->select(array('id' => $id));
        $data = $result->current();
        if(!$data) {
            return null;
        }
        $model = ContactModel::fromArray($data->getArrayCopy());
        return $model;
    }
    
//    public function findByIdentityId($identityId) {
//        $table = $this->getTableGateway($this->tableName);
//        $result = $table->select(array('identityId' => $identityId));
//        $data = $result->current();
//        if(!$data) {
//            return null;
//        }
//        $model = ContactModel::fromArray($data->getArrayCopy());
//        return $model;
//    }
    
    public function remove(ContactModel $contact) {
        
    }
}