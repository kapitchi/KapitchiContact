<?php

namespace KapitchiContact\Model\Mapper;

use     KapitchiContact\Model\Mapper\Contact as ContactMapper,
        KapitchiBase\Mapper\PluralFieldStringDbAdapter,
        KapitchiBase\Mapper\PluralFieldObjectDbAdapter,
        ZfcBase\Mapper\DbAdapterMapper,
        ZfcBase\Model\ModelAbstract,
        KapitchiContact\Model\Contact as ContactModel;

class ContactDbAdapter extends DbAdapterMapper implements ContactMapper {
    protected $tableName = 'contact';
    
    public function persist(ModelAbstract $model) {
        if($model->getId()) {
            $ret = $this->update($model);
        }
        else {
            $ret = $this->insert($model);
        }
        
        foreach(array('emails', 'phoneNumbers') as $field) {
            $mapper = $this->getPluralFieldMapper($field);
            $mapper->persist($model->getId(), $model[$field]);
        }
        
        $addressMapper = $this->getPluralFieldAddressMapper();
        $addressMapper->persist($model->getId(), $model->getAddresses());
        
        return $ret;
    }
    
    protected function insert(ModelAbstract $model) {
        $table = $this->getContactTable();
        
        $data = $model->toArray();
        unset($data['name']);
        unset($data['phoneNumbers']);
        unset($data['emails']);
        unset($data['addresses']);
        
        $data = array_merge($data, $model->getName()->toArray());
        $ret = $table->insert($data);
        $model->setId((int)$table->getLastInsertId());
        
        return $ret;
    }
    
    protected function update(ModelAbstract $model) {
        $table = $this->getContactTable();
        
        $data = $model->toArray();
        unset($data['id']);
        unset($data['phoneNumbers']);
        unset($data['emails']);
        unset($data['addresses']);
        unset($data['name']);
        
        $data = array_merge($data, $model->getName()->toArray());
        $ret = $table->update($data, array('id' => $model->getId()));
        
        return $ret;
    }
    
    public function findByPriKey($id) {
        $table = $this->getContactTable();
        $result = $table->select(array('id' => $id));
        $data = $result->current();
        if(!$data) {
            return null;
        }
        
        $array = $data->getArrayCopy();
        $model = ContactModel::fromArray($array);
        $name = \KapitchiContact\Model\Name::fromArray($array);
        $model->setName($name);
        
        foreach(array('emails', 'phoneNumbers') as $field) {
            $emailMapper = $this->getPluralFieldMapper($field);
            $model[$field] = $emailMapper->findByEntityId($id);
        }
        
        $addressMapper = $this->getPluralFieldAddressMapper();
        $model->setAddresses($addressMapper->findByEntityId($id));
        
        return $model;
    }
    
    public function getPaginatorAdapter(array $params) {
        var_dump($params);
        exit;
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
    
    public function remove(ModelAbstract $contact) {
        var_dump($contact);
        exit;
    }
    
    /**
     * TODO please fix me!!!
     * @return \KapitchiBase\Mapper\PluralFieldObjectDbAdapter 
     */
    protected function getPluralFieldAddressMapper() {
        $mapper = new \KapitchiBase\Mapper\PluralFieldObjectDbAdapter();
        $mapper->setDbAdapter($this->getReadAdapter());
        $objectMapper = new \KapitchiLocation\Model\Mapper\AddressDbAdapter();
        $objectMapper->setDbAdapter($this->getReadAdapter());
        $mapper->setObjectMapper($objectMapper);
        $mapper->setTableName('contact_addresses');
        return $mapper;
    }
    
    protected function getPluralFieldMapper($field) {
        $mapper = new PluralFieldStringDbAdapter();
        $mapper->setDbAdapter($this->getReadAdapter());
        $mapper->setTableName('contact_' . $field);
        
        return $mapper;
    }
    
    protected function getContactTable() {
        return $this->getTableGateway($this->tableName);
    }
}