<?php

namespace KapitchiContact\Service;

use KapitchiContact\Model\Mapper\Contact as ContactMapper,
    KapitchiBase\Service\ServiceAbstract,
    InvalidArgumentException as NoContactFoundException,
    KapitchiContact\Model\Contact as ContactModel;

class Contact extends ServiceAbstract {
    /**
     * @var KapitchiContact\Model\Mapper\Contact 
     */
    protected $mapper;
    
    public function persist(array $data) {
        $params = $this->triggerParamsMergeEvent('persist.pre', array('data' => $data));
        
        $model = $this->createModelFromArray($data);
        $mapper = $this->getMapper();
        
        $ret = $this->getMapper()->persist($model);
        $params['contact'] = $model;
        
        $params = $this->triggerParamsMergeEvent('persist.post', $params);
        
        return $params;
    }
    
    public function get(array $filter, $exts = array()) {
        $result = $this->events()->trigger('get.load', $this, $filter, function($ret) {
            return $ret instanceof ContactModel;
        });
        $model = $result->last();
        if(!$model instanceof ContactModel) {
            throw new NoContactFoundException("No contact found");
        }
        
        if($exts === true) {
            $this->triggerEvent('get.exts', array(
                'contact' => $model,
            ));
        } else {
            foreach($exts as $ext) {
                $this->triggerEvent('get.ext.' . $ext, array(
                    'contact' => $model,
                ));
            }
        }
        
        $this->triggerEvent('get.post', array(
            'contact' => $model,
        ));
        
        return $model;
    }
    
    protected function createModelFromArray(array $data) {
        //TODO matusz: use locator for this
        $model = \KapitchiContact\Model\Contact::fromArray($data);
        return $model;
    }
    
    protected function attachDefaultListeners() {
        parent::attachDefaultListeners();
        
        $events = $this->events();
        $mapper = $this->getMapper();
        
        //load by id
        $events->attach('get.load', function($e) use ($mapper){
            $id = $e->getParam('id');
            if(!$id) {
                return;
            }
            
            return $mapper->findById($id);
        });
    }
    
    public function setMapper($mapper) {
        $this->mapper = $mapper;
    }
    
    public function getMapper() {
        return $this->mapper;
    }
}